<?php
/**
 * SEO Helper functions for VAP website
 */

class SEOHelper {
    
    /**
     * Generate meta description from content
     */
    public static function generateMetaDescription($content, $maxLength = 160) {
        $content = strip_tags($content);
        $content = preg_replace('/\s+/', ' ', $content);
        $content = trim($content);
        
        if (strlen($content) <= $maxLength) {
            return $content;
        }
        
        return substr($content, 0, $maxLength - 3) . '...';
    }
    
    /**
     * Generate keywords from content
     */
    public static function generateKeywords($content, $additionalKeywords = []) {
        $content = strip_tags(strtolower($content));
        $words = str_word_count($content, 1);
        
        // Remove common words
        $stopWords = ['the', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'a', 'an', 'is', 'are', 'was', 'were', 'be', 'been', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should'];
        $words = array_diff($words, $stopWords);
        
        // Count word frequency
        $wordCount = array_count_values($words);
        arsort($wordCount);
        
        // Get top keywords
        $keywords = array_keys(array_slice($wordCount, 0, 10));
        
        // Add additional keywords
        $keywords = array_merge($keywords, $additionalKeywords);
        
        return implode(', ', array_unique($keywords));
    }
    
    /**
     * Generate breadcrumb structured data
     */
    public static function generateBreadcrumbStructuredData($breadcrumbs) {
        $structuredData = [
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => []
        ];
        
        foreach ($breadcrumbs as $index => $breadcrumb) {
            $structuredData["itemListElement"][] = [
                "@type" => "ListItem",
                "position" => $index + 1,
                "name" => $breadcrumb['name'],
                "item" => $breadcrumb['url']
            ];
        }
        
        return json_encode($structuredData, JSON_UNESCAPED_SLASHES);
    }
    
    /**
     * Generate canonical URL
     */
    public static function generateCanonicalUrl($path = '') {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $cleanPath = ltrim($path, '/');
        
        return $protocol . '://' . $host . '/' . $cleanPath;
    }
    
    /**
     * Generate hreflang tags
     */
    public static function generateHreflangTags($currentPath, $languages = ['hu', 'en', 'es']) {
        $tags = [];
        $baseUrl = self::generateCanonicalUrl();
        
        foreach ($languages as $lang) {
            $langCode = $lang === 'hu' ? 'Hu' : ($lang === 'en' ? 'En' : 'Sp');
            $url = $baseUrl . $currentPath . '?lang=' . $langCode;
            $tags[] = '<link rel="alternate" hreflang="' . $lang . '" href="' . $url . '">';
        }
        
        return implode("\n", $tags);
    }
    
    /**
     * Validate SEO elements
     */
    public static function validateSEO($title, $description, $keywords) {
        $issues = [];
        
        // Title validation
        if (strlen($title) < 30) {
            $issues[] = "Title is too short (should be 30-60 characters)";
        }
        if (strlen($title) > 60) {
            $issues[] = "Title is too long (should be 30-60 characters)";
        }
        
        // Description validation
        if (strlen($description) < 120) {
            $issues[] = "Meta description is too short (should be 120-160 characters)";
        }
        if (strlen($description) > 160) {
            $issues[] = "Meta description is too long (should be 120-160 characters)";
        }
        
        // Keywords validation
        $keywordCount = count(explode(',', $keywords));
        if ($keywordCount < 5) {
            $issues[] = "Too few keywords (should have 5-10 keywords)";
        }
        if ($keywordCount > 10) {
            $issues[] = "Too many keywords (should have 5-10 keywords)";
        }
        
        return $issues;
    }
}
