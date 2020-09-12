<?php

declare(strict_types=1);

namespace ReliqArts\Docweaver\Tests\Unit\Service;

use Illuminate\Contracts\Config\Repository as Config;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ReliqArts\Docweaver\Service\ConfigProvider;
use ReliqArts\Docweaver\Tests\Unit\TestCase;

/**
 * Class ConfigProviderTest.
 *
 * @coversDefaultClass \ReliqArts\Docweaver\Service\ConfigProvider
 *
 * @internal
 */
final class ConfigProviderTest extends TestCase
{
    private const ARBITRARY_CONFIG_VALUE = 'value';
    private const ARBITRARY_CONFIG_ARRAY = ['key' => self::ARBITRARY_CONFIG_VALUE];

    /**
     * @var Config|ObjectProphecy
     */
    private $config;

    protected function setUp(): void
    {
        parent::setUp();

        $this->config = $this->prophesize(Config::class);
        $this->config->get(Argument::type('string'), Argument::type('array'))
            ->willReturn(self::ARBITRARY_CONFIG_ARRAY);
        $this->config->get(Argument::type('string'), Argument::type('bool'))
            ->willReturn(true);
        $this->config->get(Argument::type('string'), Argument::cetera())
            ->willReturn(self::ARBITRARY_CONFIG_VALUE);
        $this->configProvider = new ConfigProvider($this->config->reveal());
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::getDocumentationDirectory
     */
    public function testGetDocumentationDirectory(): void
    {
        $result1 = $this->configProvider->getDocumentationDirectory();
        $result2 = $this->configProvider->getDocumentationDirectory(true);

        self::assertIsString($result1);
        self::assertIsString($result2);
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result1);
        self::assertSame(base_path(self::ARBITRARY_CONFIG_VALUE), $result2);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::getRouteConfig
     */
    public function testGetRouteConfig(): void
    {
        $result = $this->configProvider->getRouteConfig();

        self::assertIsArray($result);
        self::assertSame(self::ARBITRARY_CONFIG_ARRAY, $result);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::getRoutePrefix
     */
    public function testGetRoutePrefix(): void
    {
        $result = $this->configProvider->getRoutePrefix();

        self::assertIsString($result);
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::getRouteGroupBindings
     */
    public function testGetRouteGroupBindings(): void
    {
        $result = $this->configProvider->getRouteGroupBindings();

        self::assertIsArray($result);
        self::assertArrayHasKey('prefix', $result);
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result['key']);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::isDebug
     */
    public function testIsDebug(): void
    {
        $result = $this->configProvider->isDebug();

        self::assertIsBool($result);
        self::assertTrue($result);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::isWordedDefaultVersionAllowed
     */
    public function testIsWordedDefaultVersionAllowed(): void
    {
        $result = $this->configProvider->isWordedDefaultVersionAllowed();

        self::assertIsBool($result);
        self::assertTrue($result);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::getIndexRouteName
     */
    public function testGetIndexRouteName(): void
    {
        $result = $this->configProvider->getIndexRouteName();

        self::assertIsString($result);
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::getProductIndexRouteName
     */
    public function testGetProductIndexRouteName(): void
    {
        $result = $this->configProvider->getProductIndexRouteName();

        self::assertIsString($result);
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::getProductPageRouteName
     */
    public function testGetProductPageRouteName(): void
    {
        $result = $this->configProvider->getProductPageRouteName();

        self::assertIsString($result);
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::getCacheKey
     */
    public function testGetCacheKey(): void
    {
        $result = $this->configProvider->getCacheKey();

        self::assertIsString($result);
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::getContentIndexPageName
     */
    public function testGetContentIndexPageName(): void
    {
        $result = $this->configProvider->getContentIndexPageName();

        self::assertIsString($result);
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     * @covers ::getTemplateConfig
     * @covers \ReliqArts\Docweaver\Model\TemplateConfig
     */
    public function testGetTemplateConfig(): void
    {
        $result = $this->configProvider->getTemplateConfig();

        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result->getMasterTemplate());
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result->getMasterSection());
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result->getStyleStack());
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result->getScriptStack());
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result->getIndexTitle());
        self::assertSame(self::ARBITRARY_CONFIG_VALUE, $result->getIndexIntro());
        self::assertTrue($result->isShowProductLine());
        self::assertTrue($result->isShowFootnotes());
        self::assertTrue($result->hasStyleStack());
        self::assertTrue($result->hasScriptStack());
    }
}
