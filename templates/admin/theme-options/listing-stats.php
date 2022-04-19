<?php
/**
 * Template for rendering listing-stats settings.
 *
 * @since 2.3.4
 * @var $config
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

if ( ! empty( $_GET['success'] ) ) {
	echo '<div class="updated"><p>'.esc_html__( 'Settings successfully saved!', 'my-listing' ).'</p></div>';
}
?>
<div class="wrap">
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ) ?>" method="POST">
		<h1 class="m-heading mb30">آمار آگهی</h1>
		<div class="form-group mb30">
			<h4 class="m-heading mb5">کش کردن آگهی (بر اساس دقیقه)</h4>
			<p class="mt0 mb10">تعیین کنید که چه مقدار زمان طول بکشید تا کاربر مجددا ثبت کند.</p>
			<input type="number" class="m-input" style="max-width: 170px;" placeholder="60 minutes" name="cache_time" value="<?php echo esc_attr( $config['cache_time'] ) ?>">
		</div>

		<div class="form-group mb30">
			<h4 class="m-heading mb5">پاک کردن آمارهای قدیمی (بر اساس روز)</h4>
			<p class="mt0 mb10">تنظیم کنید که چه مدت بازدید بازدید شده در پایگاه داده ذخیره شود. این کار برای جلوگیری از فشار بر پایگاه داده و نتیجه عملکرد انجام می شود.</p>
			<input type="number" class="m-input" style="max-width: 170px;" placeholder="" min="0" name="db_time" value="<?php echo esc_attr( $config['db_time'] ) ?>">
		</div>

		<h3 class="m-heading mb30 mt40">جعبه های آمار</h3>
		<div style="max-width:700px;">
			<div class="form-group mb20 dibvt switch-setting" style="width:270px;">
				<h4 class="m-heading mb5">فعال کردن مراجعه کنندگان</h4>
				<p class="mt0 mb10">نمایش مراجعه کنندگان برتر آگهی های شما</p>
				<label class="form-switch">
					<input type="checkbox" name="show_referrers" value="1" <?php checked( true, (bool) $config['show_referrers'] ) ?>>
					<span class="switch-slider"></span>
				</label>
			</div>

			<div class="form-group mb20 dibvt switch-setting" style="width:270px;">
				<h4 class="m-heading mb5">فعال کردن مرورگرها</h4>
				<p class="mt0 mb10">نمایش مرورگرهای برتر</p>
				<label class="form-switch">
					<input type="checkbox" name="show_browsers" value="1" <?php checked( true, (bool) $config['show_browsers'] ) ?>>
					<span class="switch-slider"></span>
				</label>
			</div>

			<div class="form-group mb20 dibvt switch-setting" style="width:270px;">
				<h4 class="m-heading mb5">فعال کردن پلتفرم ها</h4>
				<p class="mt0 mb10">نمایش پلتفرم های برتر (سیستم های عامل).</p>
				<label class="form-switch">
					<input type="checkbox" name="show_platforms" value="1" <?php checked( true, (bool) $config['show_platforms'] ) ?>>
					<span class="switch-slider"></span>
				</label>
			</div>

			<div class="form-group mb20 dibvt switch-setting" style="width:270px;">
				<h4 class="m-heading mb5">فعال کردن کشورها</h4>
				<p class="mt0 mb10">نمایش کشورهای برتر.</p>
				<label class="form-switch">
					<input type="checkbox" name="show_countries" value="1" <?php checked( true, (bool) $config['show_countries'] ) ?>>
					<span class="switch-slider"></span>
				</label>
			</div>

			<div class="form-group mb20 dibvt switch-setting" style="width:270px;">
				<h4 class="m-heading mb5">فعال کردن دستگاه ها</h4>
				<p class="mt0 mb10">نمایش بازدیدها در موبایل / دسکتاپ.</p>
				<label class="form-switch">
					<input type="checkbox" name="show_devices" value="1" <?php checked( true, (bool) $config['show_devices'] ) ?>>
					<span class="switch-slider"></span>
				</label>
			</div>

			<div class="form-group mb20 dibvt switch-setting" style="width:270px;">
				<h4 class="m-heading mb5">فعال کردن آمار بازدید</h4>
				<p class="mt0 mb10">نمایش آمار بازدید در روز، 7 روز اخیر، 30 روز اخیر.</p>
				<label class="form-switch">
					<input type="checkbox" name="show_views" value="1" <?php checked( true, (bool) $config['show_views'] ) ?>>
					<span class="switch-slider"></span>
				</label>
			</div>

			<div class="form-group mb20 dibvt switch-setting" style="width:270px;">
				<h4 class="m-heading mb5">فعال کردن بازدیدهای یکتا</h4>
				<p class="mt0 mb10">نمایش بازدیدهای یکتا در روز، 7 روز اخیر، 30 روز اخیر.</p>
				<label class="form-switch">
					<input type="checkbox" name="show_uviews" value="1" <?php checked( true, (bool) $config['show_uviews'] ) ?>>
					<span class="switch-slider"></span>
				</label>
			</div>
		</div>

		<h3 class="m-heading mb30 mt20">جدول بازدیدها</h3>
		<div class="form-group mb30 dibvt" style="margin-right:40px;">
			<h4 class="m-heading mb10">فعال کردن جدول</h4>
			<label class="form-switch">
				<input type="checkbox" name="enable_chart" value="1" <?php checked( true, (bool) $config['enable_chart'] ) ?>>
				<span class="switch-slider"></span>
			</label>
		</div>

		<div class="form-group mb30 dibvt">
			<h4 class="m-heading mb15">دسته بندی های جدول</h4>
			<label>
				<input type="checkbox" class="form-checkbox" name="chart_categories[]" value="lastday" <?php checked( in_array( 'lastday', $config['chart_categories'] ) ) ?>> 24 ساعت گذشته &nbsp;
			</label>
			<label>
				<input type="checkbox" class="form-checkbox" name="chart_categories[]" value="lastweek" <?php checked( in_array( 'lastweek', $config['chart_categories'] ) ) ?>> 7 روز گذشته &nbsp;
			</label>
			<label>
				<input type="checkbox" class="form-checkbox" name="chart_categories[]" value="lastmonth" <?php checked( in_array( 'lastmonth', $config['chart_categories'] ) ) ?>> 30 روز گذشته &nbsp;
			</label>
			<label>
				<input type="checkbox" class="form-checkbox" name="chart_categories[]" value="lasthalfyear" <?php checked( in_array( 'lasthalfyear', $config['chart_categories'] ) ) ?>> 6 ماه گذشته &nbsp;
			</label>
			<label>
				<input type="checkbox" class="form-checkbox" name="chart_categories[]" value="lastyear" <?php checked( in_array( 'lastyear', $config['chart_categories'] ) ) ?>> 12 ماه گذشته
			</label>
		</div>

		<h3 class="m-heading mb30 mt20">پالت رنگ</h3>
		<div class="form-group mb30">
			<div class="dibvt" style="padding-right:20px;">
				<h4 class="m-heading mb10">رنگ #1</h4>
				<input type="text" value="<?php echo esc_attr( $config['color1'] ) ?>" data-default-color="#6c1cff" class="cts-color-picker" name="color1"></input>
			</div>

			<div class="dibvt" style="padding-right:20px;">
				<h4 class="m-heading mb10">رنگ #2</h4>
				<input type="text" value="<?php echo esc_attr( $config['color2'] ) ?>" data-default-color="#911cff" class="cts-color-picker" name="color2"></input>
			</div>

			<div class="dibvt" style="padding-right:20px;">
				<h4 class="m-heading mb10">رنگr #3</h4>
				<input type="text" value="<?php echo esc_attr( $config['color3'] ) ?>" data-default-color="#6c1cff" class="cts-color-picker" name="color3"></input>
			</div>

			<div class="dibvt" style="padding-right:20px;">
				<h4 class="m-heading mb10">رنگ #4</h4>
				<input type="text" value="<?php echo esc_attr( $config['color4'] ) ?>" data-default-color="#0079e0" class="cts-color-picker" name="color4"></input>
			</div>
		</div>

		<div class="form-group mb30">
			<div class="dibvt" style="padding-right:20px;">
				<h4 class="m-heading mb10"><em>رنگ</em> بازدیدها</h4>
				<input type="text" value="<?php echo esc_attr( $config['views_color'] ) ?>" data-default-color="#0079e0" class="cts-color-picker" name="views_color"></input>
			</div>
			<div class="dibvt">
				<h4 class="m-heading mb10"><em>رنگ</em> بازدیدهای یکتا</h4>
				<input type="text" value="<?php echo esc_attr( $config['uviews_color'] ) ?>" data-default-color="#911cff" class="cts-color-picker" name="uviews_color"></input>
			</div>
		</div>

		<div class="mt60">
			<input type="hidden" name="action" value="mylisting_update_userdash">
			<input type="hidden" name="page" value="theme-stats-settings">
			<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( 'mylisting_update_userdash' ) ) ?>">
			<button type="submit" class="btn btn-primary-alt btn-xs">ذخیره تنظیمات</button>
		</div>
	</form>
</div>