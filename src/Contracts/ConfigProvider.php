<?php

declare(strict_types=1);

namespace ReliQArts\Docweaver\Contracts;

use ReliQArts\Docweaver\Models\TemplateConfig;

interface ConfigProvider
{
    /**
     * Get directory path to where documentation are stored.
     *
     * @param bool $absolute whether to return full
     *
     * @return string
     */
    public function getDocumentationDirectory($absolute = false): string;

    /**
     * Get route config.
     *
     * @return array
     */
    public function getRouteConfig(): array;

    /**
     * Get route prefix for docs.
     *
     * @return string
     */
    public function getRoutePrefix(): string;

    /**
     * Get bindings for routes.
     *
     * @param array $bindings
     *
     * @return array
     */
    public function getRouteGroupBindings(array $bindings = []): array;

    /**
     * @return string
     */
    public function getIndexRouteName(): string;

    /**
     * @return string
     */
    public function getProductIndexRouteName(): string;

    /**
     * @return string
     */
    public function getProductPageRouteName(): string;

    public function isDebug(): bool;

    /**
     * @return bool
     */
    public function isWordedDefaultVersionAllowed(): bool;

    /**
     * @return string
     */
    public function getCacheKey(): string;

    /**
     * @return string
     */
    public function getIndexPageName(): string;

    /**
     * @return TemplateConfig
     */
    public function getTemplateConfig(): TemplateConfig;
}