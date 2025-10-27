<?php

namespace App\Console\Commands;

use Statamic\Facades\Fieldset;

use Illuminate\Console\Command;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;
use function Laravel\Prompts\alert;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;

class OrderReplicatorBlocks extends Command
{
    protected $fieldset;
    protected $field;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cairn:order-replicator-blocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Organises replicator sets into alphabetical order, based on set handle.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fieldsetHandle = search(
            label: "Select a fieldset:",
            options: fn (string $value) => $this->filterFieldsets($value)
        );

        $this->fieldset = Fieldset::find($fieldsetHandle);

        $fieldHandle = search(
            label: "Select a field:",
            options: fn (string $value) => $this->filterFields($value)
        );

        try {
            $this->field = $this->fieldset->field($fieldHandle);


            $fieldConfig = $this->field->config();

            $progress = progress(
                label: "Processing {$fieldHandle} set groups...",
                steps: $fieldConfig['sets']
            );

            $progress->start();

            foreach($fieldConfig['sets'] as $set => $config) {
                $sorted = collect($config["sets"])->sortKeys();
                $fieldConfig["sets"][$set] = $sorted->all();
                $progress->advance();
            }

            $progress->finish();

            info("Applying sorted sets to {$fieldHandle}...");

            $this->field->setConfig($fieldConfig);

            $fieldData = $this->field->toArray();

            unset($fieldData["handle"]);

            $setContents = $this->fieldset->contents();

            $fieldIndex = collect($setContents["fields"])->search(function ($field) use ($fieldHandle) {
                return isset($field["handle"]) && $field["handle"] === $fieldHandle;
            });

            $setContents['fields'][$fieldIndex]['field'] = $fieldData;

            $this->fieldset->setContents($setContents);
            $this->fieldset->save();

            info("Applied sorted sets to {$fieldHandle}");

        } catch (\Exception $e) {
            alert($e->getMessage());
        }
    }

    private function getFieldsetOptions(): array
    {
        return Fieldset::all()
            ->mapWithKeys(fn($fieldset) => [
                $fieldset->handle() => $fieldset->title()
            ])
            ->all();
    }

    private function filterFieldsets(string $value): array
    {
        if(strlen($value) === 0) {
            return $this->getFieldsetOptions();
        }

        return Fieldset::all()
            ->filter(fn($fieldset) => str_contains($fieldset->handle(), $value))
            ->mapWithKeys(fn($fieldset) => [
                $fieldset->handle() => $fieldset->title()
            ])
            ->all();
    }

    private function filterFields($value): array
    {
        $fields = $this->fieldset->fields()->all();

        if(strlen($value) === 0) {
            return $fields->map(fn($field) => $field->handle())->all();
        }

        return $fields->filter(fn($field) => str_contains($field->handle(), $value))
            ->map(fn($field) => $field->handle())
            ->all();
    }
}
