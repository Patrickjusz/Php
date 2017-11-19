# YouTubeLive Class
## Examples
```php
$liveStream = new YouTubeLive('YOUR_CHANNEL_ID', 'YOUR_API_KEY');

foreach ($liveStream->getUpcommingEventArray() as $row) {
    echo $row['title'] . '<br/>';
    echo $row['date'] . '<br/>';
    echo $row['desc'] . '<br/>';
    echo $row['img'] . '<br/>';
    echo $row['channel'] . '<br/>';
    echo $row['url'] . '<br/><br/>';
}
```