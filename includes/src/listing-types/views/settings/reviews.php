<reviews inline-template v-if="currentSubTab === 'reviews'">
	<div class="tab-content full-width">
		<div class="form-section">
			<h3>دیدگاه آگهی ها</h3>
			<p>نحوه عملکرد دیدگاه آگهی ها را سفارشی کنید، رتبه بندی ستاره ها را فعال کنید، چندین دسته رتبه بندی را اضافه کنید</p>
		</div>

		<div class="editor-column col-1-2 rows row-padding">
			<div class="form-section mb40">
				<h4 class="mb10">آپلود گالری</h4>
				<p>به کاربران اجازه بدهید که برای دیگاه خود گالری تصاویر آپلود کنند.</p>
				<label class="form-switch">
					<input type="checkbox" v-model="$root.settings.reviews.gallery.enabled">
					<span class="switch-slider"></span>
				</label>
			</div>

			<div class="form-section mb40">
				<h4 class="mb10">امتیازدهی</h4>
				<p>به کاربران اجازه دهید در کنار بررسی خود ، رتبه بندی مبتنی بر ستاره را نیز ارائه دهند.</p>

				<label class="form-switch">
					<input type="checkbox" v-model="$root.settings.reviews.ratings.enabled">
					<span class="switch-slider"></span>
				</label>

				<div class="mt10" v-show="!$root.settings.reviews.ratings.enabled">
					<p>به کاربران اجازه می دهد چندین نظر ارسال کنند؟</p>
					<label class="form-switch">
						<input type="checkbox" v-model="$root.settings.reviews.multiple">
						<span class="switch-slider"></span>
					</label>
				</div>
			</div>

			<div class="form-section" :class="!$root.settings.reviews.ratings.enabled ? 'ml-overlay-disabled' : ''">
				<h4 class="mb10">نوع ستاره ها</h4>
				<p>
					اگر روی نیم ستاره تنظیم شود، کاربران می توانند رتبه هایی مانند 1.5 ، 2.5 ، 3.5 و 4.5 را قرار دهند. در غیر این صورت ، فقط تعداد کامل رتبه بندی مانند 1 ، 2 ، 3 ، 4 و 5 امکان پذیر است.
				</p>
				<div class="form-group mb10">
					<label>
						<input type="radio" v-model="$root.settings.reviews.ratings.mode" value="5" class="form-radio">
						<span>ستاره کامل</span>
					</label>
				</div>
				<div class="form-group">
					<label>
						<input type="radio" v-model="$root.settings.reviews.ratings.mode" value="10" class="form-radio">
						<span>نیم ستاره</span>
					</label>
				</div>
			</div>
		</div><!--
		--><div class="editor-column col-1-2 rows row-padding" :class="!$root.settings.reviews.ratings.enabled ? 'ml-overlay-disabled' : ''">
			<h4>دسته بندی امتیازها</h4>

			<draggable v-model="$root.settings.reviews.ratings.categories" :options="{group: 'settings-reviews-categories', handle: '.row-head'}">
				<div v-for="category in $root.settings.reviews.ratings.categories" class="row-item" :class="isActive( category ) ? 'open' : ''">
					<div @click="activeCategory = ( isActive( category ) ? null : category )" class="row-head">
						<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
						<div class="row-head-label">
							<h4>{{ category.label }}</h4>
							<div class="details">
								<div class="detail">{{ category.id }}</div>
							</div>
						</div>
						<div class="row-head-actions">
							<span
								title="Remove" @click.stop="removeCategory( category )" class="action red"
								v-show="$root.settings.reviews.ratings.categories.length > 1 && category.id !== 'rating'"
							><i class="mi delete"></i></span>
						</div>
					</div>
					<div class="row-edit">
						<div class="form-group">
							<label>برچسب</label>
							<input type="text" v-model="category.label" @input="category.is_new ? category.id = $root.slugify( category.label ) : null">
						</div>

						<div class="form-group">
							<label>کلید</label>
							<input type="text" v-model="category.id" @input="category.is_new ? category.id = $root.slugify( category.id ) : null" :disabled="!category.is_new">
							<p class="form-description" v-show="category.is_new">باید منحصر به فرد باشد. این برای کاربر قابل مشاهده نیست.</p>
						</div>

						<div class="text-right">
							<div class="btn" @click="activeCategory = null">انجام شد</div>
						</div>
					</div>
				</div>
			</draggable>

			<div class="form-group mt20">
				<button class="btn btn-outline pull-right" @click.prevent="addCategory">افزودن دسته بندی امتیازها</button>
			</div>
		</div>
	</div>
</reviews>