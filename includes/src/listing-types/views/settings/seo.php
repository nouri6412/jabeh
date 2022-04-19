<seo inline-template v-if="currentSubTab === 'seo'">
	<div class="tab-content align-center">
		<div class="settings-tab-seo-content">
			<div class="form-section">
				<h3>نشانه گذاری اسکیما</h3>
				<p>
					از طریق سفارشی ، مشاهده لیست خود را در نتایج موتور جستجو بهینه کنید
					<a href="https://developers.google.com/search/docs/guides/intro-structured-data" target="_blank">داده های ساختاری</a> نشانه گذاری.
					می توانید از <a href="#" class="cts-show-tip" data-tip="bracket-syntax">نحو براکت</a> برای بازیابی اطلاعات لیست استفاده کنید.
				</p>
			</div>

			<div class="form-jsoneditor">
				<div class="form-group schema-markup">
					<div id="lte-seo-markup" class="lte-seo-markup"></div>
				</div><br>
				<div class="text-right">
					<a @click.prevent="setDefaultMarkup" class="btn btn-secondary">بازنشانی</a>
					<a @click.prevent="$root.setTab('settings', 'general')" class="btn btn-primary">ذخیره</a>
				</div>
			</div>
			<!-- <pre>{{ $root.settings.seo.markup }}</pre> -->
		</div>
	</div>
</seo>