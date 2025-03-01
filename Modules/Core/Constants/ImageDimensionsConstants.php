<?php

declare(strict_types=1);

namespace Modules\Core\Constants;

/**
 * Constants for image dimensions
 */
final class ImageDimensionsConstants
{
    // Common aspect ratios
    public const RATIO_SQUARE = 1 / 1;

    public const RATIO_WIDESCREEN = 16 / 9;

    public const RATIO_FACEBOOK = 1.91 / 1;

    public const RATIO_INSTAGRAM = 4 / 5;

    public const RATIO_TWITTER = 2 / 1;

    // Avatar dimensions
    public const AVATAR_MIN_WIDTH = 100;

    public const AVATAR_MIN_HEIGHT = 100;

    public const AVATAR_MAX_WIDTH = 1000;

    public const AVATAR_MAX_HEIGHT = 1000;

    public const AVATAR_RATIO = self::RATIO_SQUARE;

    // Profile photo dimensions
    public const PROFILE_MIN_WIDTH = 400;

    public const PROFILE_MIN_HEIGHT = 400;

    public const PROFILE_MAX_WIDTH = 2000;

    public const PROFILE_MAX_HEIGHT = 2000;

    public const PROFILE_RATIO = self::RATIO_SQUARE;

    // Thumbnail dimensions
    public const THUMBNAIL_MIN_WIDTH = 50;

    public const THUMBNAIL_MIN_HEIGHT = 50;

    public const THUMBNAIL_MAX_WIDTH = 500;

    public const THUMBNAIL_MAX_HEIGHT = 500;

    public const THUMBNAIL_RATIO = self::RATIO_WIDESCREEN;

    // Cover photo dimensions
    public const COVER_MIN_WIDTH = 1200;

    public const COVER_MIN_HEIGHT = 630;

    public const COVER_MAX_WIDTH = 2400;

    public const COVER_MAX_HEIGHT = 1260;

    public const COVER_RATIO = self::RATIO_FACEBOOK;

    // Banner dimensions
    public const BANNER_MIN_WIDTH = 1500;

    public const BANNER_MIN_HEIGHT = 500;

    public const BANNER_MAX_WIDTH = 3000;

    public const BANNER_MAX_HEIGHT = 1000;

    public const BANNER_RATIO = 3 / 1;

    // Social media preview dimensions
    public const SOCIAL_MIN_WIDTH = 1200;

    public const SOCIAL_MIN_HEIGHT = 630;

    public const SOCIAL_MAX_WIDTH = 2400;

    public const SOCIAL_MAX_HEIGHT = 1260;

    public const SOCIAL_RATIO = self::RATIO_FACEBOOK;

    /**
     * Get dimensions array for a specific image type
     */
    public static function getDimensions(string $type): array
    {
        $dimensions = [
            'avatar' => [
                'min_width' => self::AVATAR_MIN_WIDTH,
                'min_height' => self::AVATAR_MIN_HEIGHT,
                'max_width' => self::AVATAR_MAX_WIDTH,
                'max_height' => self::AVATAR_MAX_HEIGHT,
                'ratio' => self::AVATAR_RATIO,
            ],
            'profile' => [
                'min_width' => self::PROFILE_MIN_WIDTH,
                'min_height' => self::PROFILE_MIN_HEIGHT,
                'max_width' => self::PROFILE_MAX_WIDTH,
                'max_height' => self::PROFILE_MAX_HEIGHT,
                'ratio' => self::PROFILE_RATIO,
            ],
            'thumbnail' => [
                'min_width' => self::THUMBNAIL_MIN_WIDTH,
                'min_height' => self::THUMBNAIL_MIN_HEIGHT,
                'max_width' => self::THUMBNAIL_MAX_WIDTH,
                'max_height' => self::THUMBNAIL_MAX_HEIGHT,
                'ratio' => self::THUMBNAIL_RATIO,
            ],
            'cover' => [
                'min_width' => self::COVER_MIN_WIDTH,
                'min_height' => self::COVER_MIN_HEIGHT,
                'max_width' => self::COVER_MAX_WIDTH,
                'max_height' => self::COVER_MAX_HEIGHT,
                'ratio' => self::COVER_RATIO,
            ],
            'banner' => [
                'min_width' => self::BANNER_MIN_WIDTH,
                'min_height' => self::BANNER_MIN_HEIGHT,
                'max_width' => self::BANNER_MAX_WIDTH,
                'max_height' => self::BANNER_MAX_HEIGHT,
                'ratio' => self::BANNER_RATIO,
            ],
            'social' => [
                'min_width' => self::SOCIAL_MIN_WIDTH,
                'min_height' => self::SOCIAL_MIN_HEIGHT,
                'max_width' => self::SOCIAL_MAX_WIDTH,
                'max_height' => self::SOCIAL_MAX_HEIGHT,
                'ratio' => self::SOCIAL_RATIO,
            ],
        ];

        return $dimensions[$type] ?? [];
    }
}
