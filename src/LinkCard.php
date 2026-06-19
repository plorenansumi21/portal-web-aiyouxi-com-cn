<?php

namespace App\Helpers;

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $imageUrl;
    private string $domain;

    public function __construct(
        string $url = '',
        string $title = '',
        string $description = '',
        string $imageUrl = '',
        string $domain = ''
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
        $this->domain = $domain;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function render(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDescription = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedImageUrl = htmlspecialchars($this->imageUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDomain = htmlspecialchars($this->domain, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $html = '<div class="link-card">';
        $html .= '<a href="' . $escapedUrl . '" target="_blank" rel="noopener noreferrer">';
        
        if ($escapedImageUrl !== '') {
            $html .= '<div class="link-card-image">';
            $html .= '<img src="' . $escapedImageUrl . '" alt="' . $escapedTitle . '" loading="lazy">';
            $html .= '</div>';
        }
        
        $html .= '<div class="link-card-content">';
        $html .= '<div class="link-card-title">' . $escapedTitle . '</div>';
        
        if ($escapedDescription !== '') {
            $html .= '<div class="link-card-description">' . $escapedDescription . '</div>';
        }
        
        $html .= '<div class="link-card-domain">' . $escapedDomain . '</div>';
        $html .= '</div>';
        $html .= '</a>';
        $html .= '</div>';

        return $html;
    }

    public static function createFromArray(array $data): self
    {
        $card = new self();
        $card->setUrl($data['url'] ?? '');
        $card->setTitle($data['title'] ?? '');
        $card->setDescription($data['description'] ?? '');
        $card->setImageUrl($data['imageUrl'] ?? '');
        $card->setDomain($data['domain'] ?? '');
        return $card;
    }

    public static function renderDefaultCard(): string
    {
        $defaultData = [
            'url' => 'https://portal-web-aiyouxi.com.cn',
            'title' => '爱游戏 - 官方门户',
            'description' => '欢迎来到爱游戏，享受精彩游戏世界。',
            'imageUrl' => 'https://portal-web-aiyouxi.com.cn/images/logo.png',
            'domain' => 'portal-web-aiyouxi.com.cn',
        ];

        $card = self::createFromArray($defaultData);
        return $card->render();
    }

    public static function renderGameCard(string $gameName, string $gameUrl, string $gameDescription = ''): string
    {
        $data = [
            'url' => $gameUrl,
            'title' => $gameName . ' - 爱游戏',
            'description' => $gameDescription ?: '探索' . $gameName . '，尽在爱游戏。',
            'imageUrl' => '',
            'domain' => parse_url($gameUrl, PHP_URL_HOST) ?: 'portal-web-aiyouxi.com.cn',
        ];

        $card = self::createFromArray($data);
        return $card->render();
    }
}