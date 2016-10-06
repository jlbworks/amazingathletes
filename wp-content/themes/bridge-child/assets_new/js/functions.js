var am2 = window.am2 || {};
// Izmjenjeno od originala zbog ajaxa.
(function ($) {
	'use strict';

	am2.main = {

		init: function () {
			var self = this;
			self.togglers();
			//self.accordion();
			//self.tabsPlugin();
			self.submitFieldButton();
			self.focusOnField();
			self.select2dropdown();
			self.datepicker();
			self.responsiveTables();
			self.ajaxForm();
			self.notify();
			self.modals();
			self.cards();
			self.js_tabs();
			self.tooltip();
		},

		togglers: function () {
			// toggle body class for sidebar state
			$('.js-sidebar-toggle').click(function () {
				$('body').toggleClass('sidebar-toggled');
			});

			// toggle sidebar submenus
			$('.has_submenu > a').on('click', function (e) {
				e.preventDefault();
				$('.has_submenu').not($(this).parent()).removeClass('active');
				$(this).parent().toggleClass('active');

			});
		},

		accordion: function () {
			var animTime = 300;
			$('.am2-accordion .am2-accordion__panel').bind('click', function () {
				if ($(this).hasClass('current')) {
					$(this).removeClass('current').find('.panel__content').slideUp(animTime);
				} else {
					var currentAccordionPanel = $('.am2-accordion .am2-accordion__panel.current');
					if (currentAccordionPanel.length > 0) {
						currentAccordionPanel.removeClass('current').find('.panel__content').slideUp(animTime);
					}
					$(this).addClass('current').find('.panel__content').slideDown(animTime);
				}
			});
		},

		tabsPlugin: function () {
			$('ul.am2-tabs__titles').tabs(
				'.tabs__panel',
				{
					effect: 'fade',
					onClick: function (event, tabIndex) {
						var tab = $('.tabs__panel').eq(tabIndex);
						var tabId = tab.attr('id');
						$('.tabs__panel').removeClass('tabs__panel--current');
						tab.addClass('tabs__panel--current');
						$('#' + tabId + ' .js-slick-slider').addClass('slider--reload').slick('setPosition').removeClass('slider--reload');
					}
				}
			);
		},

		submitFieldButton: function () {

			$('[data-js="submit-field"]').click(function (ev) {

				ev.preventDefault();

				var $this = $(this);
				var $parent = $this.parents('fieldset');

				$parent.removeClass('is-focused');

			});

		},

		focusOnField: function () {

			$('[data-js="focus-on-field"]').click(function (ev) {

				ev.preventDefault();

				var $this = $(this);
				var $parent = $this.parents('fieldset');

				$parent.addClass('is-focused').find('input').focus();

			});

		},

		select2dropdown: function () {

			$('[data-js="select"]').select2({
				width: '100%',
				minimumResultsForSearch: -1
			});


			$('[data-js="select-with-search"]').select2({
				width: '100%'
			});


			var selectSourceUrl = $('[data-js="select-with-ajax"]').data('source-url');

			$('[data-js="select-with-ajax"]').select2({
				width: '100%',
				ajax: {
				    url: selectSourceUrl,
				    dataType: 'json',
				    delay: 250,
				    data: function (params) {
				    	console.log(params);
				      return {
				        q: params.term, // search term
				        page: params.page
				      };
				    },
				    processResults: function (data, params) {
				      return {results: data.items};
				    },
				    cache: false
				}
			});

		},

		responsiveTables: function () {

			$('.js-responsive-table').stacktable();

		},

		dropzone: function () {

			$('[data-js="dropzone"]').dropzone({url: "/file/post"});

		},

		tooltip: function() {
			$('.tooltip').tooltipster();
		},

		datepicker: function () {
			var $pikaday;

			// DATEPICKER DEFAULT
			$("body").on("focus",'[data-js="datepicker"]',function(){
				$pikaday = $(this).pikaday();	
			});

			// DATEPICKER DEFAULT
			$("body").on("focus",'[data-js="datepicker-format"]',function(){

				console.log(class_dates[0], class_dates[class_dates.length-1]);
				console.log(moment(class_dates[0], 'MM/DD/YYYY').toDate());
				console.log(moment(class_dates[class_dates.length-1], 'MM/DD/YYYY').toDate());

				var available_dates = class_dates.map(function(str){
					return moment(str,'MM/DD/YYYY').toDate();
				});

				if($pikaday){
					$pikaday.pikaday('destroy');					
				}

				$pikaday = $(this).pikaday({
					position: 'bottom left',
					firstDay: 1,
					/*minDate: moment(class_dates[0], 'MM/DD/YYYY').toDate(),
					maxDate: moment(class_dates[class_dates.length-1], 'MM/DD/YYYY').toDate(),*/
					availableDates: available_dates,
					yearRange: [1997, 2035],
					format: "MM/DD/YYYY"
				});
			});

			$('[data-js="clockpicker"]').clockpicker({
				donetext: 'Done'
			});

		},

		ajaxForm: function (pParent) {
			// defined parent to distribute event
			var formParent = (pParent === undefined) ? '.main' : pParent;
			// attach event on the forms that dont allready have event submited
			$(formParent + ' form.js-ajax-form:not(".js-ajax-attached")').on('submit', function (e) {
				e.preventDefault();
				// mark form with submited event
				$(formParent).find('form').addClass('js-ajax-attached');
				// get form data
				var formAction = $(this).attr('action');
				var formMethod = $(this).attr('method');
				var formData = $(this).serialize();
				var formNotifyType = $(this).data('notify');
				var formIsModal = $(this).parent().data('remodal-id');
				// make ajax request
				$.ajax({
						method: formMethod,
						url: formAction,
						data: formData,
						cache: false
					})
					.done(function (data) {
						am2.main.notify(formNotifyType, 'success', data);
						if (formIsModal) {
							$('[data-remodal-id=' + formIsModal + ']').remodal().close();
						}
					});
			});
		},

		notify: function (pType, pClass, pData) {
			// defaults
			var notifyType = pType || ''; // inline, modal, pnotify
			var notifyClass = pClass || '';
			// notifications
			if (notifyType == 'inline') {
				var str = '<div class="notify notify--' + notifyClass + '">' + pData + '<span class="close"></span></div>';
				$('#js-notifications').append(str);
				am2.main.handleinlineNotifiers();
			}
			if (notifyType == 'modal') {
				if ($('[data-remodal-id="notify"]').length > 0) {
					$('[data-remodal-id="notify"]').attr('class', '').addClass('remodal remodal-is-initialized remodal-is-closed remodal--' + notifyClass);
					$('[data-remodal-id="notify"]').find('.notify-content').html(pData);
					$('[data-remodal-id="notify"]').remodal().open();
				}
				else {
					console.log('!!! Missing Modal Notification HTML element on page !!!');
				}
			}
			if (notifyType == 'pnotify') {
				new PNotify({
					title: notifyClass,
					text: pData,
					addclass: 'brighttheme-' + notifyClass,
					type: notifyClass,
					hide: true,
					history: {
						history: false
					}
				});
			}
			// used for existing inline notifiers
			am2.main.handleinlineNotifiers();
		},
		handleinlineNotifiers: function () {
			// detect changes on inline notify container
			$('#js-notifications').bind("DOMSubtreeModified", function () {
				//console.log('inline notifiers updated');
			});
			// remove individual on click
			$('.notify .close').on('click', function (e) {
				e.preventDefault();
				var $notifier = $(this).parent();
				$notifier.addClass('notify--removed');
				setTimeout(function () {
					$notifier.remove()
				}, 500);
			});
		},

		modals: function () {
			// reinit libs required by modal content
			$(document).on('opened', '.remodal', function () {
				// if forms dont have ajax event attach, attach it
				if ($(this).find('.js-ajax-form:not(".js-ajax-attached")').length > 0) {
					am2.main.ajaxForm('.remodal');
				}
			});
		},

		cards: function () {
			$('.card-toggler').on('click', function (e) {
				e.preventDefault();
				$(this).closest('.card-wrapper').toggleClass('hidden');
			});
		},

		js_tabs: function () {

			$("body").on("click",'[data-js="js-tab"]',function(ev){
				ev.preventDefault();

				var $this = $(this);
				var $parent = $(this).parent();
				var $tab = $this.data('tab');

				if (!$parent.hasClass('is-disabled') && !$parent.hasClass('is-active')) {
					$parent.parent().find('.js-tabs-cell').removeClass('is-active');
					$('.js-tab').removeClass('is-active');
					$parent.addClass('is-active');
					$($tab).addClass('is-active');
				}

			});

			$('body').on("click",'[data-js="js-tab-next"]', function (ev) {
				ev.preventDefault();
				$('.js-tabs-cell.is-active').next().find('.js-tab-link').trigger('click');
			});

			$('body').on("click",'[data-js="js-tab-prev"]', function (ev) {
				ev.preventDefault();
				$('.js-tabs-cell.is-active').prev().find('.js-tab-link').trigger('click');
			});

		}

	};

    var viewportWidth = $(window).width();
    var viewportHeight = $(window).height();

    am2.calculations = {

        init: function () {
            var self = this;
            ($('.repeater').length ? self.repeaterPlugin():'');

            self.staffCalculationRow();
            // self.staffCalculationTotal();

            // test
            // console.log(self.onlyNum('100'));

        },
        // strip non-numeric characters from string
        onlyNum: function($num) {
            return $num.replace(/[^0-9]/g, '');
        },
        // repeater jquery plugin
        repeaterPlugin: function () {

            $(document).on('click', '[data-repeater-create-fake]', function () {
                $(this).parents('.repeater').find('[data-repeater-create]').click();
            });

            $('.repeater').repeater({
                show: function () {
                    $(this).slideDown();

                    // recall funcions
                    am2.main.focusOnField();
                    am2.main.submitFieldButton();
                    am2.main.select2dropdown();
                    am2.main.datepicker();
                    am2.calculations.staffCalculationRow();
                    am2.calculations.staffCalculationTotal();
                },
                hide: function (deleteElement) {
                    var $this = $(this);

                    // sweet alert modal
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    }, function () {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        $this.slideUp(deleteElement);

                        setTimeout(function () {
                            am2.calculations.staffCalculationTotal();
                        }, 1000);
                    });

                    // default
                    /*if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }*/

                    // default + custom calculation
                    /*if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);

                        setTimeout(function () {
                            am2.calculations.staffCalculationTotal();
                        }, 1000);
                    }*/

                },
            });
        },
        // calculate staff total in a row on submit
        staffCalculationRow: function () {
            $('[data-staff-row]').find('[data-js="submit-field"]').click(function (ev) {
                ev.preventDefault();
                var $this = $(this);
                var $datastaffhours = $this.parents('[data-staff-row]').find('[data-staff-hours]').val();
                var $datastaffrate = $this.parents('[data-staff-row]').find('[data-staff-rate]').val();
                var $datastaffrtotal = $datastaffhours * $datastaffrate;

                $datastaffrtotal = (is.not.nan($datastaffrtotal) ? $datastaffrtotal:0);

                $this.parents('[data-staff-row]').find('[data-staff-total]').val($datastaffrtotal);

                am2.calculations.staffCalculationTotal();
            });

        },
        // calculate staff total - the sum of each row
        staffCalculationTotal: function () {
            var $datastafffinaltotal = 0;

            $('[data-staff-row]').each(function() {
                var $this = $(this);
                $datastafffinaltotal += (is.not.nan($this.find('[data-staff-total]').val() && is.not.number($this.find('[data-staff-total]').val())) ? parseInt($this.find('[data-staff-total]').val()):0);
            });

            $('[data-staff-final-total]').val($datastafffinaltotal);
        }

    };

    return am2.main.init(),
        am2.calculations.init();

}($));