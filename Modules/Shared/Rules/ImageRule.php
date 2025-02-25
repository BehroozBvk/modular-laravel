<?php

declare(strict_types=1);

namespace Modules\Shared\Rules;

use Illuminate\Validation\Rule;
use Modules\Core\Constants\{
    FileConstants,
    ImageDimensionsConstants,
    ImageTypeConstants
};

class ImageRule
{
    public static function avatar(bool $required = false): array
    {
        $dimensions = ImageDimensionsConstants::getDimensions('avatar');

        $rules = [
            'image',
            'mimetypes:' . ImageTypeConstants::getMimeTypesString(),
            'mimes:' . ImageTypeConstants::getExtensionsString(),
            Rule::dimensions()
                ->minWidth($dimensions['min_width'])
                ->minHeight($dimensions['min_height'])
                ->maxWidth($dimensions['max_width'])
                ->maxHeight($dimensions['max_height'])
                ->ratio($dimensions['ratio']),
            'max:' . FileConstants::toKilobytes(FileConstants::MAX_SIZE_2MB),
        ];

        if ($required) {
            array_unshift($rules, 'required');
        } else {
            array_unshift($rules, 'nullable');
        }

        return $rules;
    }

    public static function profilePhoto(bool $required = false): array
    {
        $dimensions = ImageDimensionsConstants::getDimensions('profile');

        $rules = [
            'image',
            'mimetypes:' . ImageTypeConstants::getMimeTypesString(ImageTypeConstants::MIME_TYPES_PHOTO),
            'mimes:' . ImageTypeConstants::getExtensionsString(ImageTypeConstants::EXTENSIONS_PHOTO),
            Rule::dimensions()
                ->minWidth($dimensions['min_width'])
                ->minHeight($dimensions['min_height'])
                ->maxWidth($dimensions['max_width'])
                ->maxHeight($dimensions['max_height'])
                ->ratio($dimensions['ratio']),
            'max:' . FileConstants::toKilobytes(FileConstants::MAX_SIZE_5MB),
        ];

        if ($required) {
            array_unshift($rules, 'required');
        } else {
            array_unshift($rules, 'nullable');
        }

        return $rules;
    }

    public static function thumbnail(): array
    {
        $dimensions = ImageDimensionsConstants::getDimensions('thumbnail');

        return [
            'nullable',
            'image',
            'mimetypes:' . ImageTypeConstants::getMimeTypesString(ImageTypeConstants::MIME_TYPES_PHOTO),
            'mimes:' . ImageTypeConstants::getExtensionsString(ImageTypeConstants::EXTENSIONS_PHOTO),
            Rule::dimensions()
                ->minWidth($dimensions['min_width'])
                ->minHeight($dimensions['min_height'])
                ->maxWidth($dimensions['max_width'])
                ->maxHeight($dimensions['max_height'])
                ->ratio($dimensions['ratio']),
            'max:' . FileConstants::toKilobytes(FileConstants::MAX_SIZE_1MB),
        ];
    }

    public static function coverPhoto(): array
    {
        $dimensions = ImageDimensionsConstants::getDimensions('cover');

        return [
            'nullable',
            'image',
            'mimetypes:' . ImageTypeConstants::getMimeTypesString(ImageTypeConstants::MIME_TYPES_PHOTO),
            'mimes:' . ImageTypeConstants::getExtensionsString(ImageTypeConstants::EXTENSIONS_PHOTO),
            Rule::dimensions()
                ->minWidth($dimensions['min_width'])
                ->minHeight($dimensions['min_height'])
                ->maxWidth($dimensions['max_width'])
                ->maxHeight($dimensions['max_height'])
                ->ratio($dimensions['ratio']),
            'max:' . FileConstants::toKilobytes(FileConstants::MAX_SIZE_5MB),
        ];
    }

    public static function banner(): array
    {
        $dimensions = ImageDimensionsConstants::getDimensions('banner');

        return [
            'nullable',
            'image',
            'mimetypes:' . ImageTypeConstants::getMimeTypesString(ImageTypeConstants::MIME_TYPES_PHOTO),
            'mimes:' . ImageTypeConstants::getExtensionsString(ImageTypeConstants::EXTENSIONS_PHOTO),
            Rule::dimensions()
                ->minWidth($dimensions['min_width'])
                ->minHeight($dimensions['min_height'])
                ->maxWidth($dimensions['max_width'])
                ->maxHeight($dimensions['max_height'])
                ->ratio($dimensions['ratio']),
            'max:' . FileConstants::toKilobytes(FileConstants::MAX_SIZE_5MB),
        ];
    }

    public static function socialPreview(): array
    {
        $dimensions = ImageDimensionsConstants::getDimensions('social');

        return [
            'nullable',
            'image',
            'mimetypes:' . ImageTypeConstants::getMimeTypesString(ImageTypeConstants::MIME_TYPES_PHOTO),
            'mimes:' . ImageTypeConstants::getExtensionsString(ImageTypeConstants::EXTENSIONS_PHOTO),
            Rule::dimensions()
                ->minWidth($dimensions['min_width'])
                ->minHeight($dimensions['min_height'])
                ->maxWidth($dimensions['max_width'])
                ->maxHeight($dimensions['max_height'])
                ->ratio($dimensions['ratio']),
            'max:' . FileConstants::toKilobytes(FileConstants::MAX_SIZE_2MB),
        ];
    }
}
