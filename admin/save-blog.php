<?php
declare(strict_types=1);
require __DIR__.'/bootstrap.php';
admin_require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php#blog-editor'); exit; }

function blog_clean_html(string $html): string {
    $allowed=['p','br','strong','b','em','i','u','s','strike','ul','ol','li','blockquote','span','h2','h3','div','font'];
    if (!class_exists('DOMDocument')) return strip_tags($html, '<p><br><strong><b><em><i><u><s><strike><ul><ol><li><blockquote><span><h2><h3><div><font>');
    $dom=new DOMDocument('1.0','UTF-8');
    $previous=libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8"?><div id="blog-root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED|LIBXML_HTML_NODEFDTD);
    libxml_clear_errors(); libxml_use_internal_errors($previous);
    $root=$dom->getElementById('blog-root');
    if (!$root) return '';
    $clean=function($node) use (&$clean,$allowed) {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if (!$child instanceof DOMElement) continue;
            $tag=strtolower($child->tagName);
            $clean($child);
            if (!in_array($tag,$allowed,true)) {
                while ($child->firstChild) $child->parentNode->insertBefore($child->firstChild,$child);
                $child->parentNode->removeChild($child); continue;
            }
            $style=[];
            if ($tag==='font') {
                $face=$child->getAttribute('face');$color=$child->getAttribute('color');$size=$child->getAttribute('size');
                if ($face && preg_match('/^[a-z0-9 ,\"\'-]{1,80}$/i',$face)) $style[]='font-family:'.$face;
                if ($color && preg_match('/^(#[0-9a-f]{3,8}|[a-z]{3,20})$/i',$color)) $style[]='color:'.$color;
                if ($size && ctype_digit($size)) $style[]='font-size:'.((int)$size+8).'px';
            }
            if ($child->hasAttribute('style')) foreach (explode(';',$child->getAttribute('style')) as $decl) {
                if (!str_contains($decl,':')) continue;
                [$property,$value]=array_map('trim',explode(':',$decl,2));
                if ($property==='color' && preg_match('/^(#[0-9a-f]{3,8}|[a-z]{3,20}|rgba?\([0-9.,% ]+\))$/i',$value)) $style[]='color:'.$value;
                if ($property==='font-family' && preg_match('/^[a-z0-9 ,\"\'-]{1,80}$/i',$value)) $style[]='font-family:'.$value;
                if ($property==='font-size' && preg_match('/^[0-9.]+(px|pt|em|rem|%)$/i',$value)) $style[]='font-size:'.$value;
                if ($property==='text-align' && in_array($value,['left','center','right','justify'],true)) $style[]='text-align:'.$value;
            }
            foreach (iterator_to_array($child->attributes) as $attribute) $child->removeAttribute($attribute->name);
            if ($style) $child->setAttribute('style',implode(';',$style));
        }
    };
    $clean($root);
    $result=''; foreach ($root->childNodes as $child) $result.=$dom->saveHTML($child);
    return trim($result);
}
try {
    admin_verify_csrf();
    $title=blog_clean_html((string)($_POST['title_html']??''));
    $body=blog_clean_html((string)($_POST['body_html']??''));
    if (trim(strip_tags($title))==='' || trim(strip_tags($body))==='') throw new RuntimeException('Both the Blog title and text are required.');
    if (strlen($title)>20000 || strlen($body)>60000) throw new RuntimeException('The Blog content is too long.');
    $pdo=admin_db();
    $stmt=$pdo->prepare('INSERT INTO blog_content (id,title_html,body_html) VALUES (1,?,?) ON DUPLICATE KEY UPDATE title_html=VALUES(title_html),body_html=VALUES(body_html)');
    $stmt->execute([$title,$body]);
    $_SESSION['admin_flash']='Blog title and text saved successfully.';
} catch (Throwable $e) {
    error_log('Wintrip Blog save: '.$e->getMessage());
    $_SESSION['admin_flash']=$e instanceof RuntimeException?$e->getMessage():'Could not save Blog content. Check that the Blog SQL migration has been imported.';
}
header('Location: dashboard.php#blog-editor'); exit;
