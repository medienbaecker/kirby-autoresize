<?php

function autoresize($file) {
    $maxWidth = option('medienbaecker.autoresize.maxWidth');
    $maxHeight = option('medienbaecker.autoresize.maxHeight');
    $excludeTemplates = option('medienbaecker.autoresize.excludeTemplates');
    $excludePages = option('medienbaecker.autoresize.excludePages');
    $excluded = false;
    if(!empty($excludeTemplates)) $excluded = in_array($file->page()->intendedTemplate(), $excludeTemplates);
    if(!empty($excludePages)) $excluded = in_array($file->page()->uid(), $excludePages);
    if($file->isResizable() && !$excluded) {
        if($file->width() > $maxWidth || $file->height() > $maxHeight){
            try {
                kirby()->thumb($file->root(), $file->root(), [
                    'width'  => $maxWidth,
                    'height' => $maxHeight,
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