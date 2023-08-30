# Install
```
composer require darksandr/orchid-images
```
# Example use
## Default
```
$images = \Orchid\Attachment\Models\Attachment::find(1);
\DarKsandr\Images\Image::make($images);
```
## Custom resize name
```
\DarKsandr\Images\Image::resize('custom_name')->save($images);
```
# Config
| Name      | Description                                                                                      |
|-----------|--------------------------------------------------------------------------------------------------|
| default   | Default Image Resize Name                                                                        |
| component | Component Image Name                                                                             |
| format    | Format Image Output (Supported format: "JPEG", "PNG", "GIF", "TIF", "BMP", "ICO", "PSD", "WebP") |
| resizes   | Resizes List                                                                                     | 

## Example resize
```
/*
 |--------------------------------------------------------------------------
 | Resizes
 |--------------------------------------------------------------------------
 |
 | If empty width and height - no resize
 |
 */
'resizes' => [
    'custom_name' => [
        ['width' => 800, 'height' => null, 'name' => 'pc',     'media' => 'max-width: 799px'],
        ['width' => 300, 'height' => null, 'name' => 'mobile', 'media' => 'min-width: 800px'],
    ],
],
```
