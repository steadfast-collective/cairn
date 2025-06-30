# Cairn

### Installation
1. Setup a new Statamic site using the Statamic CLI `statamic new`
2. You'll be asked if you want to use a starter kit. Say no to this.
3. Go through the Statamic install process as per usual.
4. Once complete, add the following to your `composer.json`, (This is because a couple of packages we're using aren't published to packagist.)
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/steadfast-collective/statamic-google-maps-autocomplete.git"
    },
    {
        "type": "vcs",
        "url": "https://github.com/steadfast-collective/statamic-auth.git"
    }
]
```
5. Run `php please starter-kit:install steadfast-collective/cairn`
6. When asked `Clear Site First?`, choose yes.
9. Create a super user when prompted. 
7. Run `npm install`.
8. Run `npm run dev` or `npm run build`.
