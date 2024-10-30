jQuery ->
  jQuery(".master_link_row input[data-validation]").each (index,element)->
    checkValidation(element)
  jQuery(".master_link_row").on "keyup", "input[data-validation]", (event) ->
    input = event.target
    checkValidation(input)
  jQuery(".master_link_row").on "change", "select", (event) ->
    setupFields(event.target)
  jQuery("#master_link_upc").on "keyup", (event) ->
    input = event.target
    checkUPC(input)
  setupSortable()
  return

setupSortable = () ->
  table = jQuery("table.sortable tbody#here")
  if(table.size())
    table.sortable().disableSelection()

setupFields = (select) ->
  option = jQuery(select).find("option:selected")
  validation = option.data('validation')
  validation_error = option.data('validation_error')

  input = jQuery(select).parent().parent().children("td").children("input")
  input.attr("data-validation", ""+validation)
  input.attr("data-validation_error", ""+validation_error)

checkUPC = (input) ->
  barcode = jQuery(input).val()
  if(barcode.length == 12)
    barcode = '0'+barcode

  # check length
  if (barcode.length < 8 || barcode.length > 18 ||
      (barcode.length != 8 && barcode.length != 13 &&
      barcode.length != 14 && barcode.length != 18))
    return false


  lastDigit = Number(barcode.substring(barcode.length - 1))
  checkSum = 0
  if (isNaN(lastDigit))
    return false # not a valid upc/ean

  arr = barcode.substring(0,barcode.length - 1).split("").reverse()
  oddTotal = 0
  evenTotal = 0

  for i in [0...arr.length]
    if (isNaN(arr[i]))
      return false;  # can't be a valid upc/ean we're checking for

    if (i % 2 == 0)
      oddTotal += Number(arr[i]) * 3
    else
      evenTotal += Number(arr[i])

  checkSum = 10 - ((evenTotal + oddTotal) % 10)

  # true if they are equal
  return checkSum == lastDigit

checkValidation = (input) ->
  regexp_pattern = new RegExp(jQuery(input).data('validation'))
  validation_error = jQuery(input).data('validation_error')
  value = jQuery(input).val()
  valid = regexp_pattern.test(value)
  if(!valid)
    jQuery(input).parent("td").addClass("form-invalid")
    if(jQuery(input).parent("td").children("div.error").length == 0)
      errorHtml = "<div class=\"inline error\" style=\"position: absolute;\">"+ validation_error + "</span>"
      parent = jQuery(input).parent("td")[0]
      jQuery(parent).append(errorHtml)
  else
    jQuery(input).parent("td").find("div.error").remove()
    jQuery(input).parent("td").removeClass("form-invalid")
  return
