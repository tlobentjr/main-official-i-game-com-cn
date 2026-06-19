<?php

/**
 * Site Meta Information
 *
 * A simple collection of metadata for a fictional site.
 * Provides a method to generate a concise description text.
 */

class SiteMeta {

    /**
     * @var array<string, mixed> The metadata store.
     */
    private array $data;

    /**
     * Constructor.
     *
     * @param array $initialData Optional initial data to merge.
     */
    public function __construct(array $initialData = []) {
        $defaults = [
            'site_name'        => '爱游戏官方平台',
            'base_url'         => 'https://main-official-i-game.com.cn',
            'description'      => '提供最新最热的游戏资讯与攻略，爱游戏从这里开始。',
            'keywords'         => ['爱游戏', '游戏资讯', '官方平台', '攻略'],
            'language'         => 'zh-CN',
            'author'           => '爱游戏团队',
            'version'          => '1.0.0',
            'founded_year'     => 2024,
            'contact_email'    => 'contact@main-official-i-game.com.cn',
        ];

        $this->data = array_merge($defaults, $initialData);
    }

    /**
     * Get a specific metadata value.
     *
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public function get(string $key, $default = null): mixed {
        return $this->data[$key] ?? $default;
    }

    /**
     * Set a metadata key/value pair.
     *
     * @param string $key
     * @param mixed  $value
     * @return void
     */
    public function set(string $key, mixed $value): void {
        $this->data[$key] = $value;
    }

    /**
     * Generate a short, human-readable description text for the site.
     *
     * @param int $maxLength Maximum length of the description (approximate).
     * @return string
     */
    public function generateShortDescription(int $maxLength = 120): string {
        $name = $this->get('site_name', '');
        $desc = $this->get('description', '');
        $kw   = $this->get('keywords', []);

        // Build base text
        $base = $name ? "欢迎来到{$name}。" : '';
        if ($desc) {
            $base .= $desc;
        }

        // Append first keyword if present and not already in text
        if (!empty($kw) && mb_strpos($base, $kw[0]) === false) {
            $base .= " 关键词：{$kw[0]}";
        }

        // Trim to max length (simple approach)
        if (mb_strlen($base) > $maxLength) {
            $base = mb_substr($base, 0, $maxLength - 3) . '...';
        }

        return $base;
    }

    /**
     * Return all metadata as an array.
     *
     * @return array
     */
    public function toArray(): array {
        return $this->data;
    }

    /**
     * Render a simple HTML meta block (safe output).
     *
     * @return string
     */
    public function renderMetaTags(): string {
        $html = '';
        $html .= '<meta charset="UTF-8">' . "\n";
        $html .= '<meta name="description" content="' . htmlspecialchars($this->get('description', ''), ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="keywords" content="' . htmlspecialchars(implode(', ', $this->get('keywords', [])), ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="author" content="' . htmlspecialchars($this->get('author', ''), ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="language" content="' . htmlspecialchars($this->get('language', ''), ENT_QUOTES, 'UTF-8') . '">' . "\n";
        return $html;
    }
}

// ---------------------------------------------------------------------------
// Example usage (not executed when included, only when run directly)
// ---------------------------------------------------------------------------
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'] ?? '')) {
    $siteMeta = new SiteMeta([
        'site_name' => '爱游戏',
        'base_url'  => 'https://main-official-i-game.com.cn',
        'keywords'  => ['爱游戏', '游戏', '官方'],
    ]);

    echo "Short description: " . $siteMeta->generateShortDescription() . "\n\n";
    echo "HTML meta tags:\n" . $siteMeta->renderMetaTags() . "\n";
    echo "Full data:\n";
    print_r($siteMeta->toArray());
}