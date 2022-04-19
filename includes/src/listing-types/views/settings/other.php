<div class="tab-content align-center" v-if="currentSubTab === 'other'">

	<expiry-rules inline-template>
		<div class="form-section expiry-rules">
			<h3>قوانین انقضا</h3>
			<p>به غیر از تاریخ انقضا ، در صورت تحقق سایر شرایط می توانید لیست را منقضی کنید.</p>

			<div class="btn btn-secondary btn-block mb5 default-expiry">
				با رسیدن تاریخ انقضا منقضی می شود
			</div>

			<div v-for="rule in rules" class="btn btn-secondary btn-block mb5 rule" @click="removeRule(rule)">
				{{getRuleLabel(rule)}}
				<span>حذف قوانین</span>
			</div>

			<div class="select-wrapper text-right mt15">
				<select @change="addRule($event.target.value);$event.target.value='';">
					<option value="">
						{{ availableRules.length ? 'Add rule' : 'قوانین در دسترس نیست' }}
					</option>
					<option v-for="rule in availableRules" :value="rule.value">
						{{ rule.label }}
					</option>
				</select>
			</div>
		</div>
	</expiry-rules>

	<div class="form-section">
		<h3>نوع آگهی سراسری</h3>
		<p>
			برای نمایش فرم جستجوی سراسری، از این نوع لیست در صفحه جستجو استفاده کنید در هر نوع آگهی دیگر به دنبال نتایج باشید. شما نباید بیش از یک نوع آگهی سراسری داشته باشید. همچنین نباید علاوه بر صفحه جستجو، در صفحه افزودن آگهی یا مکان دیگری استفاده شود.
		</p>
		<label class="form-switch">
			<input type="checkbox" v-model="settings.global">
			<span class="switch-slider"></span>
		</label>
	</div>
</div>