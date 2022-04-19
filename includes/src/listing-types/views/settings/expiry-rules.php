<div class="tab-content align-center" v-if="currentSubTab === 'expiry-rules'">
	<expiry-rules inline-template>
		<div class="form-section expiry-rules">
			<h3>قوانین انقضای آگهی</h3>
			<p>به غیر از تاریخ انقضا، می توانید در صورت رعایت سایر شرایط، آگهی را منقضی کنید.</p>

			<div class="btn btn-secondary btn-block mb5 default-expiry">
				با رسیدن به تاریخ انقضا منقضی می شود
			</div>

			<div v-for="rule in rules" class="btn btn-secondary btn-block mb5 rule" @click="removeRule(rule)">
				{{getRuleLabel(rule)}}
				<span>حذف قانون</span>
			</div>

			<div class="select-wrapper text-right mt15">
				<select @change="addRule($event.target.value);$event.target.value='';">
					<option value="">
						{{ availableRules.length ? 'Add rule' : 'قوانین اضافی موجود نیست' }}
					</option>
					<option v-for="rule in availableRules" :value="rule.value">
						{{ rule.label }}
					</option>
				</select>
			</div>
		</div>
	</expiry-rules>
</div>