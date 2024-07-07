<h1>Details document of the API with example</h1>


API URL for getting shop details
----------------------------------------------
https://api.amarbangla.com.bd/api/get_shop_details/{shopID}/

Example:<br>
https://api.amarbangla.com.bd/api/get_shop_details/8

<br><br><br>




API for getting the youtube video URL of any shop
-------------------------------------------------------------------
https://api.amarbangla.com.bd/api/get_shop_youtube_url/{shopID}/

Example:<br>
https://api.amarbangla.com.bd/api/get_shop_youtube_url/8

<br><br><br>




API for getting general Setting information of any shop
-------------------------------------------------------------------
https://api.amarbangla.com.bd/api/get_shop_youtube_url/{shopID}/
https://api.amarbangla.com.bd/api/get_shop_settings_info/{shopID}/{label}/

Example:<br>
https://api.amarbangla.com.bd/api/get_shop_youtube_url/8/
https://api.amarbangla.com.bd/api/get_shop_settings_info/8/customer_panel_video

<br><br><br>



API for Local shops list
------------------------------------
https://api.amarbangla.com.bd/api/get_all_local_shop_list/{limit?}/{orderBy?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_all_local_shop_list/3/shopID/desc

<br><br><br>


https://api.amarbangla.com.bd/api/get_local_shop_list_by_category/{shop_category}/{limit?}/{orderBy?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_local_shop_list_by_category/5/3/shopID/desc

<br><br><br>


https://api.amarbangla.com.bd/api/get_local_shops_list/{global_address_id?}/{limit?}/{orderBy?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_local_shops_list/1/3/shopID/desc

<br><br><br>


API for Regular shops list
------------------------------------
https://api.amarbangla.com.bd/api/get_regular_shop_list/{limit?}/{orderBy?}/{orderType?}
https://api.amarbangla.com.bd/api/get_regular_shop_list_by_category/{shop_category}/{limit?}/{orderBy?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_regular_shop_list/5/sch_id/DESC
https://api.amarbangla.com.bd/api/get_regular_shop_list_by_category/3/3/ShopID/DESC

<br><br><br>



For slider banners
--------------------------------------------
https://api.amarbangla.com.bd/api/get_sliders

<br><br><br>



For home banner
---------------------------------------------------
https://api.amarbangla.com.bd/api/get_website_settings/home_banner
https://api.amarbangla.com.bd/api/get_website_settings/home_banner_2
https://api.amarbangla.com.bd/api/get_website_settings/home_banner_3

<br><br><br>


For popular product
---------------------------------------------------
https://api.amarbangla.com.bd/api/get_popular_products
https://api.amarbangla.com.bd/api/get_popular_products/{offset?}/{limit?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_popular_products/0/3/ASC

<br><br><br>



For hot product
----------------------------------------------------
https://api.amarbangla.com.bd/api/get_hot_products
https://api.amarbangla.com.bd/api/get_hot_products/{offset?}/{limit?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_hot_products/0/3/DESC

<br><br><br>


For featured product
------------------------------------------------------
https://api.amarbangla.com.bd/api/get_featured_products
https://api.amarbangla.com.bd/api/get_featured_products/{offset?}/{limit?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_featured_products/0/3/ASC

<br><br><br>


Get Product Image
------------------------------------------------
https://api.amarbangla.com.bd/api/get_products_image/{productID}/

Example:<br>
https://api.amarbangla.com.bd/api/get_products_image/9/

<br><br><br>


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

<br><br><br>



Product details API
------------------------------------------------------------------
https://api.amarbangla.com.bd/api/get_products_details/{productID}/{shopID}

Example:<br>
https://api.amarbangla.com.bd/api/get_products_details/80/25
https://api.amarbangla.com.bd/api/get_products_details/759/50

<br><br><br>


Product Color Option API
------------------------------------------------------------------
https://api.amarbangla.com.bd/api/get_products_color_option/{productID}/{shopID}

Example:<br>
https://api.amarbangla.com.bd/api/get_products_color_option/80/25
https://api.amarbangla.com.bd/api/get_products_color_option/87/25

<br><br><br>



Product Size Option API
------------------------------------------------------------------
https://api.amarbangla.com.bd/api/get_products_size_option/{productID}/{shopID}

Example:<br>
https://api.amarbangla.com.bd/api/get_products_size_option/80/25
https://api.amarbangla.com.bd/api/get_products_size_option/87/25

<br><br><br>



Get Featured Shop Category list
------------------------------------------------
https://api.amarbangla.com.bd/api/get_featured_shop_category/{limit?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_featured_shop_category/2/DESC

<br><br><br>


Get All Shop Category list
------------------------------------------------
https://api.amarbangla.com.bd/api/get_all_shop_category/{limit?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_all_shop_category/2/DESC

<br><br><br>


Registration
------------------------------------------------
Method POST 
URL: https://api.amarbangla.com.bd/api/customer_register

Fields keys: [
                'mobile'
                'password'
                'customer_name'
                'father_name'
                'mother_name'
                'age'
                'pass'
                'pic'
                'nid'
                'cus_type_id'
                'balance'
                'mac_address'
                'address'
                'global_address_id'
                'createdBy'
                'updatedBy'
                'deleted'
                'deletedRole'
            ]

Example:<br>
https://api.amarbangla.com.bd/api/customer_register

<br><br><br>



Login
------------------------------------------------
Method POST 
URL: https://api.amarbangla.com.bd/api/customer_login

Fields keys: [
                'mobile'
                'password'
            ]

Example:<br>
https://api.amarbangla.com.bd/api/customer_login


<br><br><br>



Global Address
------------------------------------------------
Get all divisions list
<br>
Method GET 
URL: https://api.amarbangla.com.bd/api/get_all_divisions/

Example:<br>
https://api.amarbangla.com.bd/api/get_all_divisions/


<br><br>


Get all district list by Division ID
<br>
Method GET 
URL: https://api.amarbangla.com.bd/api/get_districts_list_by_division/{division}

Example:<br>
https://api.amarbangla.com.bd/api/get_districts_list_by_division/2/

<br><br><br>

Method GET
URL: https://api.amarbangla.com.bd/get_sub_districts_list_by_district/{districtID}

Example:<br>
https://api.amarbangla.com.bd/api/get_sub_districts_list_by_district/2/

<br><br><br>

Method GET
URL: https://api.amarbangla.com.bd/api/get_pourashava_or_union/

Example:<br>
https://api.amarbangla.com.bd/api/get_pourashava_or_union/

<br><br><br>

Method GET
URL: https://api.amarbangla.com.bd/api/get_ward/

Example:<br>
https://api.amarbangla.com.bd/api/get_ward/

<br><br><br>

Get all district list by Division ID
<br>
Method GET 
URL: https://api.amarbangla.com.bd/api/get_districts_by_division/{division}/{limit?}/{orderBy?}/{orderType?}

Example:<br>
https://api.amarbangla.com.bd/api/get_districts_by_division/2/5/global_address_id/DESC/

<br><br><br>

