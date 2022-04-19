<?php
/**
 * Template for rendering map-services settings.
 *
 * @since 2.4
 * @var $config
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

if ( ! empty( $_GET['success'] ) ) {
	echo '<div class="updated"><p>'.esc_html__( 'Settings successfully saved!', 'my-listing' ).'</p></div>';
}
?>

<div class="wrap mapsettings">
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ) ?>" method="POST">
		<h1 class="m-heading mb30">خدمات نقشه</h1>

		<div class="form-group mb20 set-provider">
			<h4 class="m-heading mb5">تأمین کننده</h4>
			<p class="mt0 mb15">انتخاب کنید که برای نمایش نقشه ها ، پیشنهادات مکان و کدگذاری جغرافیایی از چه سرویسی استفاده شود.</p>
			<label class="dibvt" style="margin-right:30px;">
				<input type="radio" name="provider" value="google-maps" class="form-radio" style="margin-top:0;" <?php checked( $config['provider'] === 'google-maps' ) ?>>
				<img src="<?php echo c27()->image( 'google-maps.png' ) ?>" alt="Google Maps" height="32" class="dibvm">
			</label>
			<label class="dibvt">
				<input type="radio" name="provider" value="mapbox" class="form-radio" style="margin-top:0;" <?php checked( $config['provider'] === 'mapbox' ) ?>>
				<img src="<?php echo c27()->image( 'mapbox.png' ) ?>" alt="Mapbox" height="32" class="dibvm">
			</label>
		</div>

		<div class="gmaps-settings mt60 <?php echo $config['provider'] === 'google-maps' ? '' : 'hide' ?>">
			<div class="form-group mb30" style="max-width:420px;">
				<h4 class="m-heading mb5">API نقشه گوگل</h4>
				<p class="mt0 mb10">
					کلید API برای استفاده نقشه گوگل ضروری است.
					<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">
						برای اطلاعات بیشتر کلیک کنید.
					</a>
				</p>
				<input type="text" name="gmaps_api_key" class="m-input" value="<?php echo esc_attr( $config['gmaps_api_key'] ) ?>">
			</div>

			<div class="form-group mb30">
				<h4 class="m-heading mb5">زبان</h4>
				<p class="mt0 mb10">تنظیم کنید که نقشه ها به چه زبانی بارگیری شود.</p>
				<div class="select-wrapper dib" style="width:200px;">
					<select name="gmaps_lang">
						<?php foreach ( self::get_gmaps_lang_choices() as $lang => $label ): ?>
							<option value="<?php echo esc_attr( $lang ) ?>" <?php selected( $lang, $config['gmaps_lang'] ) ?>>
								<?php echo $label ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<div class="form-group mb30">
				<h4 class="m-heading mb5">تکمیل خودکار نتایج</h4>
				<p class="mt0 mb10">مشخص کنید چه نوع ویژگی هایی باید توسط تکمیل خودکار جستجو شود.</p>
				<label>
					<input type="radio" class="form-radio" name="gmaps_types" value="geocode" <?php checked( $config['gmaps_types'] === 'geocode' ) ?>> کد جغرافیایی &nbsp;
				</label>
				<label>
					<input type="radio" class="form-radio" name="gmaps_types" value="address" <?php checked( $config['gmaps_types'] === 'address' ) ?>> آدرس &nbsp;
				</label>
				<label>
					<input type="radio" class="form-radio" name="gmaps_types" value="establishment" <?php checked( $config['gmaps_types'] === 'establishment' ) ?>> استقرار &nbsp;
				</label>
				<label>
					<input type="radio" class="form-radio" name="gmaps_types" value="(regions)" <?php checked( $config['gmaps_types'] === '(regions)' ) ?>> منطقه &nbsp;
				</label>
				<label>
					<input type="radio" class="form-radio" name="gmaps_types" value="(cities)" <?php checked( $config['gmaps_types'] === '(cities)' ) ?>> شهرها
				</label>
			</div>

			<div class="form-group mb30">
				<h4 class="m-heading mb5">تکمیل خودکار نتایج</h4>
				<p class="mt0 mb10">نتایج تکمیل خودکار را به یک یا چند کشور محدود کنید.</p>
				<div style="width:420px;">
					<select name="gmaps_locations[]" multiple="multiple" class="custom-select">
						<?php foreach ( \MyListing\get_list_of_countries() as $country_code => $label ): ?>
							<option value="<?php echo esc_attr( $country_code ) ?>" <?php selected( in_array( $country_code, $config['gmaps_locations'] ) ) ?>>
								<?php echo $label ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<div class="form-group mb30">
				<h4 class="m-heading mb5">پوسته های سفارشی نقشه</h4>
				<p class="mt0 mb10">
					شما میتوانید با استفاده از <a href="https://mapstyle.withgoogle.com/" target="_blank">
					پوسته های سفارشی نقشه ایجاد نمایید.</a>. JSON ایجاد شده را در زیر قرار دهید.<br>
					هنگام ایجاد و ویرایش نقشه ها ، این پوسته ها در کنار گزینه های پیش فرض پوسته ظاهر می شوند.
				</p>
				<div class="custom-skins mt10">
					<script type="text/template" class="skintpl">
						<div class="custom-skin mb5">
							<input type="text" class="m-input dibvt" name="gmaps_skinkeys[]" placeholder="Label this skin">
							<input type="text" class="m-input dibvt" name="gmaps_skins[]" placeholder="Paste the JSON code here">
							<div class="btn btn-outline btn-xxs">Remove</div>
						</div>
					</script>
					<div class="custom-skin-list"><?php
						foreach ( $config['gmaps_skins'] as $label => $value ): ?>
							<div class="custom-skin mb5">
								<input type="text" class="m-input dibvt" name="gmaps_skinkeys[]" value="<?php echo esc_attr( $label ) ?>" placeholder="Label this skin">
								<input type="text" class="m-input dibvt" name="gmaps_skins[]" value="<?php echo esc_attr( $value ) ?>" placeholder="Paste the JSON code here">
								<div class="btn btn-outline btn-xxs">حذف</div>
							</div>
						<?php endforeach;
					?></div>
					<div class="btn btn-secondary btn-xs mt10 add-new"><i class="icon-add-circle-1"></i> افزودن پوسته سفارشی</div>
				</div>
			</div>
		</div>

		<div class="mapbox-settings mt60 <?php echo $config['provider'] === 'mapbox' ? '' : 'hide' ?>">
			<div class="form-group mb30" style="max-width:420px;">
				<h4 class="m-heading mb5">توکن دسترسی به جعبه نقشه</h4>
				<p class="mt0 mb10">
					توکن دسترسی به جعبه نقشه برای بارگیری نقشه الزامی است. می توانید آن را در
					<a href="https://www.mapbox.com/account/" target="_blank">دریافت کنید</a>.
				</p>
				<input type="text" name="mapbox_api_key" class="m-input" value="<?php echo esc_attr( $config['mapbox_api_key'] ) ?>">
			</div>

			<div class="form-group mb30">
				<h4 class="m-heading mb5">زبان</h4>
				<p class="mt0 mb10">تنظیم کنید که نقشه ها به چه زبانی بارگیری شود.</p>
				<div class="select-wrapper dib" style="width:200px;">
					<select name="mapbox_lang">
						<option value="default" <?php selected( 'default', $config['mapbox_lang'] ) ?>>پیشفرض (بر اساس مرورگر)</option>
						<option value="mul" <?php selected( 'mul', $config['mapbox_lang'] ) ?>>زبان محلی در هر مکان</option>
						<option value="en" <?php selected( 'en', $config['mapbox_lang'] ) ?>>انگلیسی</option>
						<option value="es" <?php selected( 'es', $config['mapbox_lang'] ) ?>>اسپانیایی</option>
						<option value="fr" <?php selected( 'fr', $config['mapbox_lang'] ) ?>>فرانسوی</option>
						<option value="de" <?php selected( 'de', $config['mapbox_lang'] ) ?>>آلمانی</option>
						<option value="ru" <?php selected( 'ru', $config['mapbox_lang'] ) ?>>روسی</option>
						<option value="zh" <?php selected( 'zh', $config['mapbox_lang'] ) ?>>چینی</option>
						<option value="pt" <?php selected( 'pt', $config['mapbox_lang'] ) ?>>پرتغالی</option>
						<option value="ar" <?php selected( 'ar', $config['mapbox_lang'] ) ?>>عربی</option>
						<option value="ja" <?php selected( 'ja', $config['mapbox_lang'] ) ?>>ژاپنی</option>
						<option value="ko" <?php selected( 'ko', $config['mapbox_lang'] ) ?>>کره ای</option>
					</select>
				</div>
			</div>

			<div class="form-group mb30">
				<h4 class="m-heading mb5">تکمیل خودکار نتایج</h4>
				<p class="mt0 mb10">مشخص کنید چه نوع ویژگی هایی باید توسط تکمیل خودکار جستجو شود. جای خالی بگذارید تا همه در آن گنجانده شود.</p>
				<div style="width:420px;">
					<select name="mapbox_types[]" class="custom-select" multiple="multiple">
						<option value="country" <?php selected( in_array( 'country', $config['mapbox_types'] ) ) ?>>کشورها</option>
						<option value="region" <?php selected( in_array( 'region', $config['mapbox_types'] ) ) ?>>مناطق</option>
						<option value="postcode" <?php selected( in_array( 'postcode', $config['mapbox_types'] ) ) ?>>کدپستی</option>
						<option value="district" <?php selected( in_array( 'district', $config['mapbox_types'] ) ) ?>>ناحیه</option>
						<option value="place" <?php selected( in_array( 'place', $config['mapbox_types'] ) ) ?>>مکان</option>
						<option value="locality" <?php selected( in_array( 'locality', $config['mapbox_types'] ) ) ?>>محلی</option>
						<option value="neighborhood" <?php selected( in_array( 'neighborhood', $config['mapbox_types'] ) ) ?>>همسایگی</option>
						<option value="address" <?php selected( in_array( 'address', $config['mapbox_types'] ) ) ?>>آدرس</option>
						<option value="poi" <?php selected( in_array( 'poi', $config['mapbox_types'] ) ) ?>>نقاط مورد علاقه</option>
						<option value="poi.landmark" <?php selected( in_array( 'poi.landmark', $config['mapbox_types'] ) ) ?>>مناطق انتخابی</option>
					</select>
				</div>
			</div>

			<div class="form-group mb30">
				<h4 class="m-heading mb5">تکمیل خودکار نتایج</h4>
				<p class="mt0 mb10">نتایج تکمیل خودکار را به یک یا چند کشور محدود کنید.</p>
				<div style="width:420px;">
					<select name="mapbox_locations[]" multiple="multiple" class="custom-select">
						<?php foreach ( \MyListing\get_list_of_countries() as $country_code => $label ): ?>
							<option value="<?php echo esc_attr( $country_code ) ?>" <?php selected( in_array( $country_code, $config['mapbox_locations'] ) ) ?>>
								<?php echo $label ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<div class="form-group mb30">
				<h4 class="m-heading mb5">استایل های سفارشی نقشه</h4>
				<p class="mt0 mb10">
					شما میتوانید استایل های سفارشی نقشه را در <a href="https://www.mapbox.com/studio/" target="_blank">استودیو مپ باکس ایجاد کنید</a>.
					آدرس استایل یا JSON تولید شده را قرار دهید.
					هنگام ایجاد و ویرایش نقشه ها ، این پوسته ها در کنار گزینه های پیش فرض پوسته ظاهر می شوند.
				</p>
				<div class="custom-skins mt10">
					<script type="text/template" class="skintpl">
						<div class="custom-skin mb5">
							<input type="text" class="m-input dibvt" name="mapbox_skinkeys[]" placeholder="Label this style">
							<input type="text" class="m-input dibvt" name="mapbox_skins[]" placeholder="Paste the style URL here">
							<div class="btn btn-outline btn-xxs">Remove</div>
						</div>
					</script>
					<div class="custom-skin-list"><?php
						foreach ( $config['mapbox_skins'] as $label => $value ): ?>
							<div class="custom-skin mb5">
								<input type="text" class="m-input dibvt" name="mapbox_skinkeys[]" value="<?php echo esc_attr( $label ) ?>" placeholder="Label this style">
								<input type="text" class="m-input dibvt" name="mapbox_skins[]" value="<?php echo esc_attr( $value ) ?>" placeholder="Paste the style URL here">
								<div class="btn btn-outline btn-xxs">حذف</div>
							</div>
						<?php endforeach;
					?></div>
					<div class="btn btn-secondary btn-xs mt10 add-new"><i class="icon-add-circle-1"></i> افزودن پوسته سفارشی</div>
				</div>
			</div>
		</div>

		<div class="mt60">
			<input type="hidden" name="action" value="mylisting_update_mapservices">
			<input type="hidden" name="page" value="theme-mapservice-settings">
			<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( 'mylisting_update_mapservices' ) ) ?>">
			<button type="submit" class="btn btn-primary-alt btn-xs">ذخیره تنظیمات</button>
		</div>
	</form>
</div>
