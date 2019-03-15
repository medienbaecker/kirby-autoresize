<?php
Kirby::plugin('medienbaecker/autoresize', [
    'options' => [
        'maxWidth' => 2000
    ],
    'hooks' => [
        'file.create:after' => function ($file) {
            if($file->isResizable()) {
                if($file->width() > option('medienbaecker.autoresize.maxWidth')) {
                    try {
                        kirby()->thumb($file->root(), $file->root(), [
                            'width' => option('medienbaecker.autoresize.maxWidth')
                        ]);
                    } catch (Exception $e) {
                        throw new Exception($e->getMessage());
                    }
                }
            }
        },
        'file.replace:after' => function ($newFile, $oldFile) {
            kirby()->trigger('file.create:after', $newFile);
        }
    ]
]);
