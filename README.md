# Autoresize for Kirby 3

Automatically resize images on upload.

![Resizing a huge image](https://user-images.githubusercontent.com/7975568/51390756-73ff4480-1b30-11e9-913d-7c6ba78fb7bd.gif)

## Options

```php
return [
  'medienbaecker.autoresize.maxWidth' => 2000,
  'medienbaecker.autoresize.maxHeight' => 2000,
  'medienbaecker.autoresize.excludeTemplates' => [
    'home',
    'project'
  ],
  'medienbaecker.autoresize.excludePages' => [
    'projects/project-a'
  ],
];
```
