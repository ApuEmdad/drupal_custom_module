## Create the .info.yml file:

Inside your theme directory, create a file named `quality_framework.info.yml`. This file will contain metadata about your theme, including its name, description, version, regions, and any dependencies. Here's a basic example:

```yml
name: "Quality Framework"
type: theme
description: "A custom theme for the project Quality Framework"
core_version_requirement: ^10
base theme: false
stylesheets-remove:
 - "normalize.css"
libraries:
 - "quality_framework/global-styling"
```

## Create the .libraries.yml file:

In your theme directory, create a file named your_theme_name.libraries.yml. This file defines the CSS and JavaScript assets that your theme will use. Here's an example

```yml
global-styling:
 css:
  theme:
   css/style.css: {}
   css/bootstrap_5.min.css: {}
   scss/style.css: {}
 js:
  js/bootstrap_5.bundle.min.js: {}
```

## Place the css, scss and js files accordingly to the path of .libraries.yml:

```
.
└── web
    └── themes
        └── contrib
            └── quality_framework
                └── css
                │   ├── style.css
                │   ├── bootstrap_5.min.css
                │   └── scss
                │       └── style.css
                └── js
                │    └── bootstrap_5.bundle.min.js
                └──quality_framework.info.yml
                └──quality_framework.libraries.yml
```
