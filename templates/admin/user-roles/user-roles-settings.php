<?php
/**
 * MyListing user-roles settings screen.
 *
 * @since 2.5
 */
if ( ! defined('ABSPATH') ) {
	exit;
} ?>

<?php if ( ! empty( $_GET['saved'] ) ): ?>
	<div class="updated"><p>تنظیمات با موفقیت ذخیره شد.</p></div>
<?php endif ?>

<div class="wrap mylisting-options" id="mylisting-roles" v-cloak>
	<div class="mb40" style="max-width: 900px;">
		<h1 class="m-heading mb30">حساب های کاربری و قوانین</h1>

		<div class="form-group mb30 inline-option">
			<h4 class="m-heading mb5">فعال کردن ثبت نام کاربر</h4>
			<p class="mt0 mb10">به مشتریان اجازه دهید در صفحه "حساب کاربری من" حساب ایجاد کنند</p>
			<label class="form-switch">
				<input type="checkbox" v-model="config.settings.enable_registration">
				<span class="switch-slider"></span>
			</label>
		</div>

		<div class="form-group mb30 inline-option">
			<h4 class="m-heading mb5">نام کاربری را به طور خودکار ایجاد کنید</h4>
			<p class="mt0 mb10">
				هنگام ایجاد حساب ، به طور خودکار نام کاربری حساب ایجاد کنید
				برای مشتری بر اساس نام ، نام خانوادگی یا ایمیل او
			</p>
			<label class="form-switch">
				<input type="checkbox" v-model="config.settings.generate_username">
				<span class="switch-slider"></span>
			</label>
		</div>

		<div class="form-group mb30 inline-option">
			<h4 class="m-heading mb5">ایجاد گذرواژه به صورت خودکار</h4>
			<p class="mt0 mb10">هنگام ایجاد حساب ، به طور خودکار رمز ورود حساب ایجاد کنید</p>
			<label class="form-switch">
				<input type="checkbox" v-model="config.settings.generate_password">
				<span class="switch-slider"></span>
			</label>
		</div>

		<div class="form-group mb30 inline-option">
			<h4 class="m-heading mb5">نوع پیشفرض حساب کاربری</h4>
			<p class="mt0 mb10">این گزینه از پیش انتخاب شده در فرم ثبت نام خواهد بود.</p>
			<div class="select-wrapper">
				<select v-model="config.roles.default_form">
					<option value="primary">{{config.roles.primary.label}}</option>
					<option value="secondary" v-if="config.roles.secondary.enabled">
						{{config.roles.secondary.label}}
					</option>
				</select>
			</div>
		</div>

		<div class="form-group mb30 inline-option">
			<h4 class="m-heading mb5">فعال کردن ریکپچا گوگل در فرم ورود</h4>
			<p class="mt0 mb10">
				<a href="<?php echo admin_url('edit.php?post_type=job_listing&page=mylisting-settings#captcha-config') ?>">
					تنظیمات ریکپچا
				</a>
			</p>
			<label class="form-switch">
				<input type="checkbox" v-model="config.roles.login_captcha">
				<span class="switch-slider"></span>
			</label>
		</div>

		<div class="form-group mb30 inline-option">
			<h4 class="m-heading mb5">فعال کردن ریکپچا گوگل در فرم ثبت نام</h4>
			<p class="mt0 mb10">
				<a href="<?php echo admin_url('edit.php?post_type=job_listing&page=mylisting-settings#captcha-config') ?>">
					تنظیات ریکپچا
				</a>
			</p>
			<label class="form-switch">
				<input type="checkbox" v-model="config.roles.register_captcha">
				<span class="switch-slider"></span>
			</label>
		</div>
	</div>

	<h3 class="m-heading mb20">قوانین کاربران و مجوزها</h3>
	<div v-for="role, roleKey in {primary: roles.primary, secondary: roles.secondary}" class="role-settings">
		<h2>
			{{ role.label }}
			<span>{{ roleKey === 'secondary' ? 'نوع حساب کاربری متغیر' : 'نوع حساب کاربری اصلی' }}</span>
		</h2>

		<div class="settings-wrapper">
			<div v-if="roleKey === 'secondary'" class="form-group mt20 mb20 enable-role">
				<h4 class="m-heading mb5">فعال کردن نوع متغیر حساب کاربری</h4>
				<p class="mt0 mb10">
					در صورت فعال بودن ، کاربران می توانند نقش خود را هنگام ثبت نام انتخاب کنند.
					می توانید مجوزها و قسمتهای مختلف ثبت نام را برای این کار پیکربندی کنید.<br><br>
					این اجازه می دهد تا انواع مختلف کاربر ، به عنوان مثال مشاغل و کاربران خصوصی ،
					کارفرمایان و جویندگان کار و غیره.
				</p>
				<label class="form-switch">
					<input type="checkbox" v-model="role.enabled">
					<span class="switch-slider"></span>
				</label>
			</div>

			<div v-if="roleKey === 'primary' || (roleKey === 'secondary' && role.enabled)">
				<div class="form-group mb30">
					<h4 class="m-heading mb5">نام قانون</h4>
					<p class="mt0 mb10">
						هنگام فیلتر کردن کاربران بر اساس نقش و غیره ، از این برچسب در فرم ثبت نام کاربر استفاده خواهد شد.
					</p>
					<input type="text" v-model="role.label" class="m-input"
						:placeholder="roleKey === 'primary' ? 'e.g. &quot;Business User&quot;' : 'e.g. &quot;Private User&quot;'">
				</div>

				<div class="form-group mb30">
					<h4 class="m-heading mb5">افزودن آگهی</h4>
					<p class="mt0 mb10">
						به کاربران دارای این نقش اجازه دهید آگهی های جدیدی را از طریق فرم "افزودن آگهی جدید" ارسال کنند.
					</p>
					<label class="form-switch">
						<input type="checkbox" v-model="role.can_add_listings">
						<span class="switch-slider"></span>
					</label>
				</div>

				<div class="form-group mb30">
					<h4 class="m-heading mb5">می تواند نقش را تغییر دهد</h4>
					<p v-if="roleKey === 'primary'" class="mt0 mb10">
						در صورت فعال بودن ، کاربران با این نقش امکان تعویض را دارند
						از طریق داشبورد کاربر ، به نوع حساب جایگزین بروید.
					</p>
					<p v-else class="mt0 mb10">
						در صورت فعال بودن ، کاربران با این نقش امکان تعویض را دارند
						از طریق داشبورد کاربر به نوع حساب اصلی بروید.
					</p>
					<label class="form-switch">
						<input type="checkbox" v-model="role.can_switch_role">
						<span class="switch-slider"></span>
					</label>
				</div>

				<div class="form-group">
					<h4 class="m-heading mb5">فیلدهای فرم ثبت نام</h4>
					<p class="mt0 mb10">
						تعیین کنید چه زمینه هایی در فرم ثبت نام برای این نقش نشان داده شود.
					</p>
					<div class="register-fields tabs-content">
						<draggable v-model="role.fields" :options="{group: 'fields-'+roleKey, handle: '.row-head'}">
							<div v-for="field in role.fields" class="row-item" :class="field === activeField ? 'open' : ''">
								<div @click="activeField = (field !== activeField) ? field : null" class="row-head">
									<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
									<div class="row-head-label">
										<h4>{{ field.label }}</h4>
										<div class="details">
											<div class="detail">{{ field.slug }}</div>
										</div>
									</div>
									<div class="row-head-actions">
										<span title="Remove" v-if="!isFieldRequired(field)" @click.stop="deleteField(field, roleKey)" class="action red">
											<i class="mi delete"></i>
										</span>
									</div>
								</div>
								<div class="row-edit" v-if="activeField === field">
									<div class="field-settings-wrapper">
										<div v-if="field.slug === 'username' && config.settings.generate_username" class="form-group">
											<p class="mb0 mt0">
												نام کاربری در حال حاضر پیکربندی شده است تا به طور خودکار تولید شود ، بنابراین این کار می کند. فیلد در فرم ثبت نام نشان داده نمی شود.
											</p>
										</div>

										<div v-if="field.slug === 'password' && config.settings.generate_password" class="form-group">
											<p class="mb0 mt0">
												رمز ورود در حال حاضر پیکربندی شده است تا به طور خودکار تولید شود ، بنابراین این کار انجام می شود. فیلد در فرم ثبت نام نشان داده نمی شود.
											</p>
										</div>

										<?php foreach ( \MyListing\Src\User_Roles\get_field_types() as $field_type ): ?>
											<?php echo $field_type->print_editor_options() ?>
										<?php endforeach ?>
									</div>

									<div class="text-right">
										<div class="btn btn-xs" @click="activeField = null">انجام شد</div>
									</div>
								</div>
							</div>
						</draggable>

						<div class="mt20" v-if="hasAvailableFields(roleKey)">
							<p class="mt0 mb10">فیلدهای فعال</p>
							<div
								v-for="field, key in config.presets"
								class="btn btn-secondary btn-xs"
								style="margin: 0 6px 8px 0;"
								v-if="!hasField(key, roleKey)"
								@click="addField(key, roleKey)"
							>{{field.label}}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ) ?>" method="POST">
		<input type="hidden" name="roles_config" :value="rolesJson">
		<input type="hidden" name="general_settings" :value="settingsJson">
		<input type="hidden" name="action" value="mylisting_role_settings">
		<input type="hidden" name="_wpnonce"
			value="<?php echo esc_attr( wp_create_nonce( 'mylisting_role_settings' ) ) ?>">
		<button type="submit" class="btn btn-primary-alt btn-xs">ذخیره تنظیمات</button>
	</form>

	<!-- <pre>{{$data}}</pre> -->
</div>