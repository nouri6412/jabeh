<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<div class="tab-content full-width" v-if="currentSubTab == 'order'">
	<div class="form-section">
		<h3>نحوه ترتیب نتایج را در صفحه جستجو تنظیم کنید ، و اینکه چه لیست هایی ابتدا باید نشان داده شوند</h3>
		<p>این گزینه ها در لیست کشویی "مرتب سازی بر اساس" در صفحه جستجو ظاهر می شوند. برای ویرایش روی گزینه ای کلیک کنید. برای مرتب کردن مجدد ، آن را بکشید و رها کنید.</p>
	</div>

	<div class="editor-column col-2-3 rows row-padding">
		<div class="form-section mb10">
			<h4 class="mb5">گزینه های مرتب سازی</h4>
			<p>برای ویرایش کلیک کنید. برای ترتیب بکشید و رها کنید.</h4>
		</div>

		<draggable v-model="search.order.options" :options="{group: 'search-order-options', handle: '.row-head'}">
			<div v-for="option, opt_key in search.order.options" class="row-item" :class="option === state.search.active_order ? 'open' : ''">
				<div class="row-head" @click="state.search.active_order = ( option !== state.search.active_order ) ? option : null">
					<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
					<div class="row-head-label">
						<h4>{{ option.label }}</h4>
						<div class="details">
							<div class="detail">{{ option.key }}</div>
						</div>
					</div>
					<div class="row-head-actions">
						<span title="Remove" @click.stop="searchTab().removeOption(option)" class="action red"><i class="mi delete"></i></span>
					</div>
				</div>
				<div class="row-edit">
					<div class="form-group">
						<label>برچسب</label>
						<input type="text" v-model="option.label" @input="searchTab().setOptionKey(option)">
					</div>

					<div class="form-group">
						<label>کلید</label>
						<input type="text" :value="option.key" @input="option.key = slugify( $event.target.value )">
						<p>
							از این کلید می توان برای انتخاب خودکار این گزینه با استفاده از یک پارامتر url استفاده کرد
						</p>
					</div>

					<div class="clauses">
						<div class="clause" v-for="clause, key in option.clauses">
							<div class="clause-heading mt20">
								<div class="editor-column col-1-2">
									<h4>ویرایش بند #{{ key + 1 }}</h4>
								</div><!--
								--><div class="editor-column col-1-2 text-right">
									<div class="btn btn-xs btn-plain" v-show="key >= 1" @click="searchTab().removeClause(clause, option)"><i class="mi delete"></i> حذف</div>
								</div>
							</div>

							<div class="form-group">
								<label>مرتب سازی بر اساس</label>
								<div class="select-wrapper">
									<select v-model="clause.context">
										<option value="option">گزینه</option>
										<option value="meta_key">فیلد سفارشی</option>
										<option value="raw_meta_key">فیلد خام</option>
									</select>
								</div>

								<div>
									<p v-show="clause.context == 'option' || ! clause.context">
										سفارش بر اساس گزینه: از یکی از روشهای سفارش ارائه شده در مرحله بعدی استفاده کنید.
									</p>

									<p v-show="clause.context == 'meta_key'">
										سفارش براساس فیلد سفارشی: برای سفارش از یکی از قسمتهایی که در برگه "فیلدها" اضافه کرده اید استفاده کنید.
									</p>

									<p v-show="clause.context == 'raw_meta_key'">
										ترتیب بر اساس فیلد خام: از یک فیلد متا لیست استفاده کنید که در برگه "زمینه ها" اضافه نشده است ، بلکه به صورت برنامه ای یا توسط افزونه دیگری اضافه نشده است.
									</p>
								</div>
							</div>

							<div class="form-group">
								<div v-show="clause.context == 'option' || ! clause.context">
									<label>انتخاب گزینه</label>
									<div class="select-wrapper">
										<select v-model="clause.orderby">
											<option value="date">تاریخ</option>
											<option value="title">عنوان</option>
											<option value="author">نویسنده</option>
											<option value="rating">امتیاز</option>
											<option value="proximity">محدوده</option>
											<option value="comment_count">تعداد دیدگاه</option>
											<option value="relevance">ارتباط</option>
											<option value="menu_order">ترتیب منو</option>
											<option value="rand">رندوم</option>
											<option value="ID">شناسه آگهی</option>
											<option value="name">نامک</option>
											<option value="modified">تاریخ آخرین ویرایش</option>
											<option value="none">هیچکدام</option>
										</select>
									</div>
								</div>

								<div v-show="clause.context === 'meta_key'">
									<label>انتخاب فیلد</label>
									<div class="select-wrapper">
										<select v-model="clause.orderby">
											<option v-for="field in fieldsByType(['recurring-date', 'number', 'date', 'checkbox', 'radio', 'select', 'text', 'password'])" :value="field.slug">
												{{ field.label }}
											</option>
										</select>
									</div>
								</div>

								<div v-show="clause.context === 'raw_meta_key'">
									<label>وارد کردن کلید فیلد</label>
									<input type="text" v-model="clause.orderby">
								</div>
							</div>

							<div class="form-group" v-if="
								(clause.context === 'meta_key' && searchTab().optionType(clause.orderby)!=='recurring-date')
								|| clause.context === 'raw_meta_key'">
								<label>ساختار تاریخ</label>
								<div class="select-wrapper" v-show="!clause.custom_type">
									<select v-model="clause.type">
										<option value="CHAR">متن</option>
										<option value="NUMERIC">عدد</option>
										<option value="DATE">تاریخ</option>
										<option value="DATETIME">زمان</option>
										<option value="TIME">زمان</option>
										<option value="DECIMAL">اعشاری</option>
										<option value="UNSIGNED">بدون علامت</option>
										<option value="SIGNED">علامت گذاری شده</option>
										<option value="BINARY">دودویی</option>
									</select>
								</div>
								<input type="text" v-show="clause.custom_type" v-model="clause.type">
								<p class="mt10">
									<label><input type="checkbox" v-model="clause.custom_type" class="form-checkbox"> Enter manually</label>
									<span v-show="clause.custom_type">اگر از انواع "اعشاری" یا "عددی" استفاده می کنید (برای مثال ، "اعشاری (10،5)" یا "عددی (10)" معتبر هستند ، از این برای تعیین دقت و مقیاس استفاده کنید.</span>
								</p>
							</div>

							<div class="form-group">
								<label class="mb5">ترتیب</label>
								<label><input type="radio" v-model="clause.order" value="ASC" :name="'clause-order-' + key + '-option-' + opt_key" class="form-radio mb5">سعودی</label>
								<label><input type="radio" v-model="clause.order" value="DESC" :name="'clause-order-' + key + '-option-' + opt_key" class="form-radio">نزولی</label>
							</div>
						</div>
					</div>

					<div class="mt5 mb5 text-center">
						<div class="btn btn-outline btn-xs mb5" @click="searchTab().addClause(option)">{{ option.clauses.length === 1 ? 'افزودن بند ثانویه' : 'Add ordering clause' }}</div>
						<div class="btn btn-plain btn-xs" v-if="option.clauses.length > 1">توجه: افزودن چندین بند سفارش می تواند عملکرد جستجو را به شدت کاهش دهد.</div>
					</div>

					<hr>

					<div class="form-group full-width">
						<label class="mt10"><input type="checkbox" v-model="option.ignore_priority" class="form-checkbox"> اولویت لیست را نادیده بگیرید</label>
						<p>
							لیست ها براساس آنها ترتیب داده می شوند <a href="#" class="cts-show-tip" data-tip="priority-docs">سطح اولویت</a> ابتدا.
							اگر می خواهید این رفتار را برای این گزینه سفارش خاص غیرفعال کنید ، از این تنظیم استفاده کنید.
						</p>
					</div>

					<div class="text-right">
						<div class="btn" @click="state.search.active_order = null">انجام شد</div>
					</div>
				</div>
			</div>
		</draggable>

		<div v-if="!search.order.options.length" class="mt40 text-center">
			<div class="btn btn-plain">
				<i class="mi playlist_add"></i>
				گزینه ای افزوده نشده
			</div>
		</div>
	</div><!--
	--><div class="editor-column col-1-3">
		<div class="form-section mb10">
			<h4 class="mb5">گزینه های سفارشی از پیش تعیین شده.</h4>
			<p>برای استفاده از آن گزینه را کلیک کنید.</h4>
		</div>

		<div class="btn btn-block mb10" @click.prevent="searchTab().addOption( 'Latest', 'latest', 'date', 'DESC', 'option' )">جدیدترین آگهی ها</div>
		<div class="btn btn-block mb10" @click.prevent="searchTab().addOption( 'Top rated', 'top-rated', 'rating', 'DESC', 'option', 'DECIMAL(10,2)', false, true )">پر امتیازترین</div>
		<div class="btn btn-block mb10" @click.prevent="searchTab().addOption( 'Nearby', 'nearby', 'proximity', 'ASC', 'option' )">آگهی های نزدیک</div>
		<div class="btn btn-block mb10" @click.prevent="searchTab().addOption( 'A-Z', 'a-z', 'title', 'ASC', 'option' )">الف - ی</div>
		<div class="btn btn-block mb10" @click.prevent="searchTab().addOption( 'Random', 'random', 'rand', 'DESC', 'option' )">رندوم</div>

		<div class="text-center mt20">
			<div class="btn btn-outline mb10" @click.prevent="searchTab().addOption()">افزودن ترتیب سفارشی</div>
		</div>
	</div>
</div>