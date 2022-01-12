<?php

function autoresize($file) {
    $maxWidth = option('medienbaecker.autoresize.maxWidth');
    $maxHeight = option('medienbaecker.autoresize.maxHeight');
    $quality = option('medienbaecker.autoresize.quality');
    $excludeTemplates = option('medienbaecker.autoresize.excludeTemplates');
    $excludePages = option('medienbaecker.autoresize.excludePages');
    $excludedByTemplate = false;
    $excludedByPage = false;
    if($file->page()) {
        if(!empty($excludeTemplates)) $excludedByTemplate = in_array($file->page()->intendedTemplate(), $excludeTemplates);
        if(!empty($excludePages)) $excludedByPage = in_array($file->page()->uid(), $excludePages);
    }
    if($file->isResizable() && !$excludedByTemplate && !$excludedByPage) {
        if($file->width() > $maxWidth || $file->height() > $maxHeight){
            try {
                kirby()->thumb($file->root(), $file->root(), [
                    'width'   => $maxWidth,
                    'height'  => $maxHeight,
                    'quality' => $quality
                ]);
            }
            catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
}

Kirby::plugin('medienbaecker/autoresize', [
    'options' => [
        'maxWidth' => 2000,
        'maxHeight' => 2000,
        'quality' => 90,
        'excludeTemplates' => [],
        'excludePages' => []
    ],
    'hooks' => [
        'file.create:after' => function ($file) {
            autoresize($file);
        },
        'file.replace:after' => function ($newFile, $oldFile) {
            autoresize($newFile);
        }
    ]
]);