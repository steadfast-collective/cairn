<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Statamic\Facades\Fieldset;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Statamic\Console\RunsInPlease;

use function Laravel\Prompts\info;
use function Laravel\Prompts\alert;
use function Laravel\Prompts\text;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;

class MakeBlock extends Command
{

    use RunsInPlease;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cairn:make:block';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold a new page builder block';

    protected $block;
    protected $fieldset;
    protected $pageBuilderFieldset;
    protected $pageBuilderField;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->block['name'] = $this->promptForName();
        $this->block['handle'] = $this->promptForHandle();
        $this->block['instructions'] = $this->promptForInstructions();
        $this->block['icon'] = $this->promptForIcon();

        $this->createTemplate();
        $this->createFieldset();
        $this->addToPageBuilder();

        info("Page builder block '{$this->block['name']}' added.");
    }

    private function promptForName(): string
    {
        return text(
            label: 'Provide a name for this block',
            required: true
        );
    }

    private function promptForHandle(): string
    {
        return text(
            label: 'Add a handle for this block',
            default: Str::slug($this->block['name'], '_'),
            required: true
        );
    }

    private function promptForInstructions(): string
    {
        return text(
            label: 'Provide instructions for this block',
            required: false
        );
    }

    private function promptForIcon(): string
    {
        return $this->pickIcon('Select an icon to use for this block');
    }

    private function pickIcon(string $label): string
    {
        $iconPath = base_path(config('cairn.commands.makeBlock.icon_path'));
        $icons = collect(File::allFiles($iconPath))
            ->map(fn ($file) => str_replace('.svg', '', $file->getBasename('.'.$file->getExtension())));

        return search(
            label: $label,
            options: function (string $value) use ($icons) {
                if (! $value) {
                    return $icons
                        ->values()
                        ->all();
                }

                return $icons
                    ->filter(fn (string $item) => Str::contains($item, $value, true))
                    ->values()
                    ->all();
            },
            placeholder: 'add-circle',
            scroll: 10,
            required: true
        );
    }

    private function createTemplate(): void
    {
        $stubPath = resource_path('stubs/block.antlers.html.stub');
        $outputPath = resource_path('views/page_builder/_' . $this->block['handle'] . '.antlers.html');

        $stub = File::get($stubPath);

        $content = str_replace(
            ['{{ name }}', '{{ filename }}', '{{ filepath }}'],
            [
                $this->block['name'],
                $this->block['handle'],
                'page_builder/' . $this->block['handle'],
            ],
            $stub
        );

        File::put($outputPath, $content);
    }

    private function createFieldset(): void
    {
        $fieldset = Fieldset::make('block_' . $this->block['handle'])
            ->setContents([
                'title' => "Block: {$this->block['name']}",
                'fields' => config('cairn.commands.makeBlock.default_fields'),
            ])->save();

        $this->fieldset = $fieldset;
    }

    private function addToPageBuilder()
    {
        // Get page builder fieldset
        $this->pageBuilderFieldset = Fieldset::find(config('cairn.commands.makeBlock.page_builder_fieldset_handle'));

        if(!$this->pageBuilderFieldset) {
            alert("Page Builder Fieldset Not Found! Aborting...");
            return COMMAND::FAILURE;
        }

        // Get field within set
        $this->pageBuilderField = $this->pageBuilderFieldset->field(config('cairn.commands.makeBlock.page_builder_field_handle'));

        if(!$this->pageBuilderField) {
            alert("Page Builder Field Not Found! Aborting...");
            return COMMAND::FAILURE;
        }

        $fieldConfig = $this->pageBuilderField->config();

        $setGroup = $this->promptForSetGroup();


        $fieldConfig["sets"][$setGroup]["sets"][$this->block['handle']] = [
            'display' => $this->block['name'],
            'icon' => $this->block['icon'],
            'instructions' => $this->block['instructions'],
            'fields' => [
                [
                    'import' => $this->fieldset->handle()
                ]
            ]
        ];

        $this->pageBuilderField->setConfig($fieldConfig);

        $fieldData = $this->pageBuilderField->toArray();

        // remove handle
        unset($fieldData['handle']);


        $setContents = $this->pageBuilderFieldset->contents();

        $fieldIndex = collect($setContents['fields'])->search(function ($field) {
            return isset($field['handle']) && $field['handle'] === config('cairn.commands.makeBlock.page_builder_field_handle');
        });;

        $setContents["fields"][$fieldIndex]["field"] = $fieldData;

        $this->pageBuilderFieldset->setContents($setContents);
        $this->pageBuilderFieldset->save();
    }

    private function promptForSetGroup(): string
    {
        return select(
            label: "Select Set Group:",
            options: collect($this->pageBuilderField->config()['sets'])->keys()
        );
    }
}
