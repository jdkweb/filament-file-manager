<?php

namespace Jdkweb\FilamentFileManager\Enums;

enum Icons : string
{
    case CSS = 'css.svg';
    case DOCX = 'docx.svg';
    case MSWORD = 'msword.svg';
    case JS = 'javascript.svg';
    case PDF = 'pdf.svg';
    case ZIP = 'zip.svg';
    case XLS = 'xls.svg';
    case TXT = 'plain.svg';
    case HTML = 'html.svg';

    public function getIconPath(): ?string
    {
        return match ($this) {
            self::CSS => '/filament_file_manager/images/' . self::CSS->value,
            self::DOCX => '/filament_file_manager/images/' . self::DOCX->value,
            self::MSWORD => '/filament_file_manager/images/' . self::MSWORD->value,
            self::JS => '/filament_file_manager/images/' . self::JS->value,
            self::PDF => '/filament_file_manager/images/' . self::PDF->value,
            self::ZIP => '/filament_file_manager/images/' . self::ZIP->value,
            self::XLS => '/filament_file_manager/images/' . self::XLS->value,
            self::TXT => '/filament_file_manager/images/' . self::TXT->value,
            self::HTML => '/filament_file_manager/images/' . self::HTML->value,
            default => null,
        };
    }

    public static function getFileType(string $mime_type): ?Icons
    {
        return match ($mime_type) {
            'application/pdf' => self::PDF,
            'application/zip' => self::ZIP,
            'application/x-zip-compressed' => self::ZIP,
            'text/css' => self::CSS,
            'text/javascript' => self::JS,
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => self::DOCX,
            'application/msword' => self::MSWORD,
            'application/vnd.ms-excel' => self::XLS,
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => self::XLS,
            'text/plain' => self::TXT,
            'text/html' => self::HTML,
            default => null,
        };
    }

    public static function getExtension($enum)
    {
        return match ($enum) {
            self::CSS => '.css',
            self::DOCX => '.docx',
            self::MSWORD => '.doc',
            self::JS => '.js',
            self::PDF => '.pdf',
            self::ZIP => '.zip',
            self::XLS => '.xls, .xlst',
            self::TXT => '.txt',
            self::HTML => '.html',
            default => null,
        };
    }

    public static function extensions(): array
    {
        return array_map(fn($enum) => self::getExtension($enum), self::cases());
    }

    /**
     * @TODO
     * @return array
     */
    public static function mime_types(): array
    {
        return array_map(fn($enum) => self::getExtension($enum), self::cases());
    }

    public static function names(): array
    {
        return array_map(fn($enum) => $enum->name, self::cases());
    }

    public static function values(): array
    {
        return array_map(fn($enum) => $enum->value, self::cases());
    }
}
