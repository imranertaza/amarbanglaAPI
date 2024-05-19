<h1>Details document of the API with example</h1>


API URL for getting shop details
----------------------------------------------
https://api.amarbangla.com.bd/api/get_shop_details/{shopID}/

Example:<br>
https://api.amarbangla.com.bd/api/get_shop_details/8




API for getting the youtube video URL of any shop
-------------------------------------------------------------------
https://api.amarbangla.com.bd/api/get_shop_youtube_url/{shopID}/

Example:<br>
https://api.amarbangla.com.bd/api/get_shop_youtube_url/8




API for getting general Setting information of any shop
-------------------------------------------------------------------
https://api.amarbangla.com.bd/api/get_shop_youtube_url/{shopID}/
https://api.amarbangla.com.bd/api/get_shop_settings_info/{shopID}/{label}/

Example:<br>
https://api.amarbangla.com.bd/api/get_shop_youtube_url/8/
https://api.amarbangla.com.bd/api/get_shop_settings_info/8/customer_panel_video



API for Local shops list
------------------------------------
https://api.amarbangla.com.bd/api/get_local_shop_list/{limit?}/{orderBy?}/{orderType?}

https://api.amarbangla.com.bd/api/get_local_shop_list_by_category/{shop_category}/{limit?}/{orderBy?}/{orderType?}



API for Regular shops list
------------------------------------
https://api.amarbangla.com.bd/api/get_regular_shop_list/{limit?}/{orderBy?}/{orderType?}
https://api.amarbangla.com.bd/api/get_regular_shop_list_by_category/{shop_category}/{limit?}/{orderBy?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_regular_shop_list/5/sch_id/DESC
https://api.amarbangla.com.bd/api/get_regular_shop_list_by_category/3/3/ShopID/DESC



For slider banners
--------------------------------------------
https://api.amarbangla.com.bd/api/get_sliders



For home banner
---------------------------------------------------
https://api.amarbangla.com.bd/api/get_website_settings/home_banner
https://api.amarbangla.com.bd/api/get_website_settings/home_banner_2
https://api.amarbangla.com.bd/api/get_website_settings/home_banner_3


For popular product
---------------------------------------------------
https://api.amarbangla.com.bd/api/get_popular_products
https://api.amarbangla.com.bd/api/get_popular_products/{offset?}/{limit?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_popular_products/0/3/ASC

For hot product
----------------------------------------------------
https://api.amarbangla.com.bd/api/get_hot_products
https://api.amarbangla.com.bd/api/get_hot_products/{offset?}/{limit?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_hot_products/0/3/DESC


For featured product
------------------------------------------------------
https://api.amarbangla.com.bd/api/get_featured_products
https://api.amarbangla.com.bd/api/get_featured_products/{offset?}/{limit?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_featured_products/0/3/ASC


Get Product Image
------------------------------------------------
https://api.amarbangla.com.bd/api/get_products_image/{productID}/

Example:<br>
https://api.amarbangla.com.bd/api/get_products_image/9/


Search API (POST REQUEST)
------------------------------------------------
https://api.amarbangla.com.bd/api/search/
https://api.amarbangla.com.bd/api/search/{limit?}
https://api.amarbangla.com.bd/api/search/{limit?}/{orderType?}


Example:<br>
https://api.amarbangla.com.bd/api/search/

post with the search key: search_item
Normally search_item = any product name

Note: if search_item == #4, it's means it will search shop which shop ID is 4



Product details API
------------------------------------------------------------------
https://api.amarbangla.com.bd/api/get_products_details/{productID}/{shopID}

Example:<br>
https://api.amarbangla.com.bd/api/get_products_details/80/25
https://api.amarbangla.com.bd/api/get_products_details/759/50


Product Color Option API
------------------------------------------------------------------
https://api.amarbangla.com.bd/api/get_products_color_option/{productID}/{shopID}

Example:<br>
https://api.amarbangla.com.bd/api/get_products_color_option/80/25
https://api.amarbangla.com.bd/api/get_products_color_option/87/25



Product Size Option API
------------------------------------------------------------------
https://api.amarbangla.com.bd/api/get_products_size_option/{productID}/{shopID}

Example:<br>
https://api.amarbangla.com.bd/api/get_products_size_option/80/25
https://api.amarbangla.com.bd/api/get_products_size_option/87/25



Get Featured Shop Category list
------------------------------------------------
https://api.amarbangla.com.bd/api/get_featured_shop_category/{limit?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_featured_shop_category/2/DESC


Get All Shop Category list
------------------------------------------------
https://api.amarbangla.com.bd/api/get_all_shop_category/{limit?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_all_shop_category/2/DESC
