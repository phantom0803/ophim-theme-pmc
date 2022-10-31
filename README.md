# THEME - PMC 2022 - OPHIM CMS

## Demo
### Trang Chủ
![Alt text](https://i.ibb.co/fxJ5yrV/PMC-INDEX.png "Home Page")

### Trang Danh Sách Phim
![Alt text](https://i.ibb.co/grn5hDx/PMC-CATALOG.png "Catalog Page")

### Trang Thông Tin Phim
![Alt text](https://i.ibb.co/ZdC6qW3/PMC-SINGLE.png "Single Page")

### Trang Xem Phim
![Alt text](https://i.ibb.co/nsfQ0JL/PMC-EPISODE.png "Episode Page")

## Requirements
https://github.com/hacoidev/ophim-core

## Install
1. Tại thư mục của Project: `composer require ophimcms/theme-pmc`
2. Kích hoạt giao diện trong Admin Panel

## Update
1. Tại thư mục của Project: `composer update ophimcms/theme-pmc`
2. Re-Activate giao diện trong Admin Panel

## Note
- Một vài lưu ý quan trọng của các nút chức năng:
    + `Activate` và `Re-Activate` sẽ publish toàn bộ file js,css trong themes ra ngoài public của laravel.
    + `Reset` reset lại toàn bộ cấu hình của themes
    
## Document
### List

- Trang chủ:  `Label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_more_url|show_template (section_poster_1|section_poster_2)`
    + `Phim lẻ mới||type|single|updated_at|desc|12|/danh-sach/phim-le|section_poster_1`
    + `Phim bộ mới||type|series|updated_at|desc|10|/danh-sach/phim-bo|section_poster_2`
    + `Phim thịnh hành||is_copyright|0|view_week|desc|7||section_poster_1`

### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/theme-pmc/resources/views/themepmc`
- Copy file cần custom đến: `/resources/views/vendor/themes/themepmc`
