<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php echo css("schedule.css");?>
<script type="text/javascript">
/*<![CDATA[*/
	document.addLoadEvent(function(){
		$('#btnSave').click(function(){
									 
			$('#displayMessage').html('');						 
			 $('select#cbChannel option').each(function(){
				if(this.selected){
					$('#hndChannel').val(this.text);
				}
			 });

			$('#frmSchedule').submit();
		});

		$('#btnCancel').click(function(){
			window.location = '<?php echo site_url("schedule");?>';
		});

		$('#cbPartner').change(function(){
			$('#cbChannel').focus();
			var url = '<?php echo site_url("schedule/is_pull");?>' + '/' + this.value;
			$.getJSON(url, function(data) {
				if(data == 'pull'){
					$('#simple_schedule').hide();
					$('#datetime_schedule').hide();
				}else{
					$('#simple_schedule').show();
					$('#datetime_schedule').show();
				}
			});
		});
		
		$('#cbChannel').change(function(){
			$('#cbPartner').focus();
		});

		$('#rdSimpleSchedule').click(function(){
			rdSimpleSchedule_Click();
		});

		$('#lblSimpleSchedule').click(function(){
			$('#rdSimpleSchedule').click();
		});

		$('#rdDateTimeSchedule').click(function(){
			rdDateTimeSchedule_Click();
		});

		$('#lblDateTimeSchedule').click(function(){
			$('#rdDateTimeSchedule').click();
		});

		$("#frmSchedule").validate({
			rules: {
				cbPartner: "required",
				cbChannel: "required"
			},
			messages: {
				cbPartner: "Please select a partner.",
				cbChannel: "Please select a chanel."
			}
		});

		$('span.radio').click(function(){
			element = this.nextSibling;
			if(element.id == 'rdDateTimeSchedule'){
				rdDateTimeSchedule_Click();
			}
			if(element.id == 'rdSimpleSchedule'){
				rdSimpleSchedule_Click();
			}
		});
		
		var today = new Date();
		$('#hndClientTimezone').val(today.getTimezoneOffset());

		/*$('select[name|=mins[]] option').click(function(){
			this.selected = (this.selected) ? false : true;
		});*/

	<?php if(isset($method) and $method == 'pull'){?>
		$('#simple_schedule').hide();
		$('#datetime_schedule').hide();
	<?php }?>
	});
	
	function rdSimpleSchedule_Click(){
		$('select[name|=mins[]]').each(function(){
			this.disabled = true;
		});
		$('select[name|=hours[]]').each(function(){
			this.disabled = true;
		});
		$('select[name|=days[]]').each(function(){
			this.disabled = true;
		});
		$('select[name|=months[]]').each(function(){
			this.disabled = true;
		});
		$('select[name|=weekdays[]]').each(function(){
			this.disabled = true;
		});
		$('select[name|=cbSimpleSchedule]').each(function(){
			this.disabled = false;
		});
	}
	
	function rdDateTimeSchedule_Click(){
		$('select:disabled').each(function(){
			this.disabled = false;
		});
		$('select[name|=cbSimpleSchedule]').each(function(){
			this.disabled = true;
		});
	}
/*]]>*/
</script>
<div id="displayError" class="error"><?php echo $ERROR;?></div>
<div id="displayMessage" class="message"><?php echo $MESSAGE;?></div>
<form id="frmSchedule" name="frmSchedule" method="post" action="<?php echo site_url("schedule/save");?>">
  <div class="section clearfix">
    <div id="schedule_buttons">
      <input type="button" id="btnSave" name="btnSave" title="Save" class="button" value="Save"/>
      <input type="button" id="btnCancel" name="btnCancel" title="Cancel" class="button" value="Cancel"/>
    </div>
    <h3>{t}Schedule{/t}</h3>
  </div>
  <div class="mod-content clearfix">
    <div class="mod-inner">
      <div class="left" style="width:100%">
        <div class="inner">
          <table class="tform">
            <tr>
              <td width="150" align="right" class="row1"><label for="cbPartner">Partner Name</label>
                *</td>
              <td><select id="cbPartner" name="cbPartner" class="styled">
                  <option value="">-- Select a Partner --</option>
                  <?php foreach($partners as $partner){?>
                  <option value="<?php echo $partner->id?>" <?php echo ($schedule != null and (int)$schedule->partner_id === (int)$partner->id) ? 'selected=""' : '';?>> <?php echo $partner->name?> </option>
                  <?php }?>
                </select></td>
              <td width="150" align="right" class="row1"><label for="cbChannel">Video Package</label>
                *</td>
              <td class="w150"><select id="cbChannel" name="cbChannel" class="styled">
                  <option value="">-- Select a Video Package --</option>
                  <?php foreach($channels as $channel){?>
                  <option value="<?php echo $channel->embedCode?>" <?php echo ($schedule != null and $schedule->channel_embedcode === $channel->embedCode) ? 'selected=""' : '';?>> <?php echo truncate($channel->title, 50);?> </option>
                  <?php }?>
                </select></td>
            </tr>
            <tr> 
              <!--td class="row1" width="150"><label for="txtStartDate">Start Date</label>*</td>
							<td>
								<input class="inputbox" name="txtStartDate" id="txtStartDate" type="text" value="<?php echo ($schedule != null) ? date('m/d/Y', strtotime($schedule->start_date)) : '';?>" />
							</td-->
              <td width="150" align="right" class="row1"><label for="chkIsActive">Active</label></td>
              <td><input class="styled" name="chkIsActive" id="chkIsActive" type="checkbox" <?php echo ($schedule != null && (int) $schedule->is_active > 0) ? 'checked="checked"' : '';?> value="1" /></td>
              <td width="150" align="right" class="row1"><label for="txtStartDate"></label></td>
              <td></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="right" style="width:100%" id="simple_schedule">
        <div class="inner">
          <table class="tform">
            <tr>
              <td width="50%"><input type="radio" name="rdSchedule" id="rdSimpleSchedule" value="0" <?php echo $is_simple_schedule ? 'checked=""' : '';?> class="styled" />
                <label for="rdSimpleSchedule" id="lblSimpleSchedule">Simple schedule</label>
                <select id="cbSimpleSchedule" name="cbSimpleSchedule" <?php echo !$is_simple_schedule ? 'disabled=""' : '';?> class="styled">
                  <?php foreach($simple_schedules as $key => $simple_schedule){?>
                  <option value="<?php echo $key?>" <?php echo ($schedule != null and $schedule->cron_expression === $key) ? 'selected=""' : '';?>> <?php echo $simple_schedule?> </option>
                  <?php }?>
                </select></td>
              <td style="text-align:left;"><input type="radio" name="rdSchedule" id="rdDateTimeSchedule" value="1"  <?php echo !$is_simple_schedule ? 'checked=""' : '';?> class="styled" />
                <label for="rdDateTimeSchedule" id="lblDateTimeSchedule">Times and dates below</label></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="right" style="width:100%" id="datetime_schedule">
        <div class="inner">
          <table class="tform">
            <tr>
              <td width="30%">Minutes</td>
              <td width="20%">Hours</td>
              <td width="20%">Days</td>
              <td width="15%">Months</td>
              <td width="15%">Weekdays</td>
            </tr>
            <tr>
              <td><select scrolling="no" class='no-scroll-bar' name="mins[]" size="12" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php for($min = 0; $min < 12; $min++){?>
                  <option value="<?php echo $min?>" <?php echo in_array($min, $selected_mins, true) ? 'selected=""' : '';?>> <?php echo $min?> </option>
                  <?php }?>
                </select>
                <select class='no-scroll-bar' name="mins[]" size="12" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php for($min = 12; $min < 24; $min++){?>
                  <option value="<?php echo $min?>" <?php echo in_array($min, $selected_mins, true) ? 'selected=""' : '';?>> <?php echo $min?> </option>
                  <?php }?>
                </select>
                <select class='no-scroll-bar' name="mins[]" size="12" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php for($min = 24; $min < 36; $min++){?>
                  <option value="<?php echo $min?>" <?php echo in_array($min, $selected_mins, true) ? 'selected=""' : '';?>> <?php echo $min?> </option>
                  <?php }?>
                </select>
                <select class='no-scroll-bar' name="mins[]" size="12" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php for($min = 36; $min < 48; $min++){?>
                  <option value="<?php echo $min?>" <?php echo in_array($min, $selected_mins, true) ? 'selected=""' : '';?>> <?php echo $min?> </option>
                  <?php }?>
                </select>
                <select class='no-scroll-bar' name="mins[]" size="12" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php for($min = 48; $min < 60; $min++){?>
                  <option value="<?php echo $min?>" <?php echo in_array($min, $selected_mins, true) ? 'selected=""' : '';?>> <?php echo $min?> </option>
                  <?php }?>
                </select></td>
              <td><select class='no-scroll-bar' name="hours[]" size="12" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php for($hour = 0; $hour < 12; $hour++){?>
                  <option value="<?php echo $hour?>" <?php echo in_array($hour, $selected_hours, true) ? 'selected=""' : '';?>> <?php echo $hour?> </option>
                  <?php }?>
                </select>
                <select class='no-scroll-bar' name="hours[]" size="12" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php for($hour = 12; $hour < 24; $hour++){?>
                  <option value="<?php echo $hour?>" <?php echo in_array($hour, $selected_hours, true) ? 'selected=""' : '';?>> <?php echo $hour?> </option>
                  <?php }?>
                </select></td>
              <td valign="top" style="vertical-align:top;"><select class='no-scroll-bar' name="days[]" size="12" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php for($day = 1; $day < 13; $day++){?>
                  <option value="<?php echo $day?>" <?php echo in_array($day, $selected_days, true) ? 'selected=""' : '';?>> <?php echo $day?> </option>
                  <?php }?>
                </select>
                <select class='no-scroll-bar' name="days[]" size="12" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php for($day = 13; $day < 25; $day++){?>
                  <option value="<?php echo $day?>" <?php echo in_array($day, $selected_days, true) ? 'selected=""' : '';?>> <?php echo $day?> </option>
                  <?php }?>
                </select>
                <select class='no-scroll-bar' name="days[]" size="7" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php for($day = 25; $day < 32; $day++){?>
                  <option value="<?php echo $day?>" <?php echo in_array($day, $selected_days, true) ? 'selected=""' : '';?>> <?php echo $day?> </option>
                  <?php }?>
                </select></td>
              <td><select class='no-scroll-bar' name="months[]" size="12" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php foreach($months as $key => $month){?>
                  <option value="<?php echo $key?>" <?php echo in_array($key, $selected_months, true) ? 'selected=""' : '';?>> <?php echo $month?> </option>
                  <?php }?>
                </select></td>
              <td><select class='no-scroll-bar' name="weekdays[]" size="7" multiple="multiple" <?php echo $is_simple_schedule ? 'disabled=""' : '';?>>
                  <?php foreach($weekdays as $key => $weekday){?>
                  <option value="<?php echo $key?>" <?php echo in_array($key, $selected_weekdays, true) ? 'selected=""' : '';?>> <?php echo $weekday?> </option>
                  <?php }?>
                </select></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="hndClientTimezone" id="hndClientTimezone" value="0">
  <input type="hidden" name="hndScheduleId" id="hndScheduleId" value="<?php echo ($schedule != null) ? $schedule->id : '0';?>">
  <input type="hidden" name="hndChannel" id="hndChannel" value="">
</form>
