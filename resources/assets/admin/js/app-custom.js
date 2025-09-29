$(document).ready(function () {
	var input = document.querySelector("#phone");
	var validMsg = document.querySelector("#valid-msg");
	var errorMsg = document.querySelector("#error-msg");
	var buttonSbmit = document.getElementById("submit");
	var errorMap = [`Invalid Number`, `Invalid country code`
		, `Too Short`, `Too Long`
	];
	var path = window.location.origin + '/tell/utils.js';

	var iti = window.intlTelInput(input, {
		initialCountry: "auto"
		, geoIpLookup: function (callback) {
			$.get('https://ipinfo.io', function () { }, "jsonp").always(function (resp) {
				var countryCode = (resp && resp.country) ? resp.country : "";
				callback(countryCode);
			});
		}
		, utilsScript: path

		,
	});
	var reset = function () {
		input.classList.remove("error");
		errorMsg.innerHTML = "";
		errorMsg.classList.add("hide");
		validMsg.classList.add("hide");
	}
	input.addEventListener('blur', function () {
		reset();
		if (input.value.trim()) {
			if (iti.isValidNumber()) {
				validMsg.classList.remove('hide');
				validMsg.innerHTML = `Valid`;

				buttonSbmit.removeAttribute("disabled", "");
			} else {
				input.classList.add('error');
				var errorCode = iti.getValidationError();
				errorMsg.innerHTML = errorMap[errorCode];
				errorMsg.classList.remove("hide");
				validMsg.innerHTML = "";
				buttonSbmit.setAttribute("disabled", "true");
			}
		}
	});
	input.addEventListener('change', reset);
	input.addEventListener("keyup", reset);
});


$(document).ready(function () {

	// press check will check all checkbox
	$("#check-all").click(function () {
		$("input[type=checkbox]").prop("checked", $(this).is(':checked'));


	});
	$('.checkbox-check').on('click', function () {
		var checked = $('.checkbox-check').is(':checked');
		if (checked == true) {
			$('.bluck-actions').show();
		}
		else {
			$('.bluck-actions').hide();
		}

	});

	$("#buttons").submit(function (e) {
		e.preventDefault();
	});

	$(document).ready(function(){
		$("#name-slug").on('keyup', function(){
			var Text = $(this).val();
			Text = Text.toLowerCase();
			Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g,'-');
			$("#slug").val(Text);
		});

	});
	$(document).ready(function(){
		$("#slug").on('keyup', function(){
			var Text = $(this).val();
			Text = Text.toLowerCase();
			Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g,'-');
			$("#slug").val(Text);
		});

	});



	var AddNew = false;

	// jQuery.fn.extend({
	// 	createRepeater: function (options = {}) {
	// 		var hasOption = function (optionKey) {
	// 			return options.hasOwnProperty(optionKey);
	// 		};

	// 		var option = function (optionKey) {
	// 			return options[optionKey];
	// 		};

	// 		var generateId = function (string) {
	// 			return string
	// 				.replace(/\[/g, '_')
	// 				.replace(/\]/g, '')
	// 				.toLowerCase();
	// 		};

	// 		var addItem = function (items, key, fresh = true) {
	// 			var itemContent = items;
	// 			var group = itemContent.data("group");
	// 			var item = itemContent;
	// 			var input = item.find('input,select,textarea');

	// 			input.each(function (index, el) {
	// 				var attrName = $(el).data('name');
	// 				var attrValue = $(el).data('value');
	// 				var skipName = $(el).data('skip-name');

	// 				if ($(el).attr('data-type') != "old_id") {
	// 					if (skipName != true) {
	// 						$(el).attr("name", group + "[" + key + "]" + "[" + attrName + "]");
	// 					} else {
	// 						if (attrName != 'undefined') {
	// 							$(el).attr("name", attrName);
	// 						}
	// 					}
	// 					if (fresh == true) {
	// 						if (AddNew == true) {
	// 							$(el).attr('value', "");
	// 							$(el).html("");
	// 						}
	// 						else {
	// 							$(el).attr('value', attrValue);
	// 						}
	// 					}

	// 					$(el).attr('id', generateId($(el).attr('name')));
	// 					$(el).parent().find('label').attr('for', generateId($(el).attr('name')));
	// 				}

	// 			})

	// 			var itemClone = items;

	// 			/* Handling remove btn */
	// 			var removeButton = itemClone.find('.remove-btn');

	// 			if (key == 0) {
	// 				removeButton.attr('disabled', true);
	// 			} else {
	// 				removeButton.attr('disabled', false);
	// 			}

	// 			removeButton.attr('onclick', '$(this).parents(\'.items\').remove()');

	// 			// removeButton.on('click', function(){
	// 			// 	$(this).closest('.main-items').find('.old_id').remove();
	// 			// });

	// 			var newItem = $("<div class='items'>" + itemClone.html() + "<div/>");
	// 			newItem.attr('data-index', key)

	// 			newItem.appendTo(repeater);
	// 		};



	// 		/* find elements */
	// 		var repeater = this;
	// 		var items = repeater.find(".items");
	// 		var key = 0;
	// 		var addButton = repeater.find('.repeater-add-btn');
	// 		items.each(function (index, item) {
	// 			items.remove();
	// 			if (hasOption('showFirstItemToDefault') && option('showFirstItemToDefault') ==
	// 				true) {
	// 				addItem($(item), key);
	// 				key++;
	// 			} else {
	// 				if (items.length > 1) {
	// 					addItem($(item), key);
	// 					key++;
	// 				}
	// 			}
	// 		});

	// 		/* handle click and add items */
	// 		addButton.on("click", function () {
	// 			AddNew = true;
	// 			addItem($(items[0]), key);
	// 			key++;
	// 		});
	// 	}
	// });
	$("#repeater").createRepeater({
		showFirstItemToDefault: true,
	});

	colorPicker.addEventListener("input", updateFirst, false);
	colorPicker.addEventListener("change", watchColorPicker, false);

	function watchColorPicker(event) {
	document.querySelectorAll("p").forEach((p) => {
		p.style.color = event.target.value;
	});
}

});

var orientation = '';
var count = 0;
$("table").find('thead tr th').each(function () {
    count++;
});
if (count > 6) {
    orientation = 'landscape';
} else {
    orientation = 'portrait';
}
$(document).ready(function () {
	var table = $('#main-datatable').DataTable({
		dom: 'Blfrtip',
		searching: false,
		lengthChange: false,
		paging: false,
		info: false,
		"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		"pageLength": 50,
		"sScrollY": "100%",
		"sScrollX": "100%",
		buttons:  [
			{
				extend: 'copy',
				className : 'btn btn-sm btn-primary m-1 datatables-btn text-start',
				text: '<i class="bx bx-copy" ></i> Copy',
				visible: false,
			},
			{
				extend: 'excel',
				orientation: orientation,
				className : 'btn btn-sm btn-primary m-1 float-right datatables-btn text-start',
				text: '<i class="bx bxs-file" ></i> Excel',
				visible: false,
			},
			{
			    extend: 'pdf',
				orientation: orientation,
			    className : 'btn btn-sm btn-primary m-1 float-right datatables-btn text-start',
			    text: '<i class="bx bxs-file-pdf"></i> PDF',
				visible: false,
			},
			{
				extend: 'print',
				orientation: orientation,
				className : 'btn btn-sm btn-primary m-1 float-right datatables-btn text-start ',
				text: '<i class="bx bx-printer" ></i> print',
				visible: false,
			},
		],
		
	});

	table.buttons().container()
		.appendTo('#main-datatable_wrapper .col-md-6:eq(0)');

});

function selectRefresh() {
	$('.select2').select2({
		tags: true
		, placeholder: "Select an Option"
		, allowClear: true
		, width: '100%'
	});
}


function togglePasswordVisibility() {
	const passwordInput = document.getElementById("inputChoosePassword");
	const visibilityIcon = document.getElementById("passwordVisibilityIcon");

	// console.log(passwordInput, visibilityIcon);

	if (passwordInput.type === "password") {
		passwordInput.type = "text";
		visibilityIcon.classList.replace("bx-hide", "bx-show");
	} else {
		passwordInput.type = "password";
		visibilityIcon.classList.replace("bx-show", "bx-hide");
	}
}

$(document).ready(function() {
	selectRefresh();
	$("#check-all").click(function() {
		$("input[type=checkbox]").prop("checked", $(this).is(':checked'));
	});


	$("#selectAll").click(function() {
		$(".refers input[type=checkbox]").prop("checked",true);
	});

	$("#selectNone").click(function() {
		$(".refers input[type=checkbox]").prop("checked",false);
	});
});




