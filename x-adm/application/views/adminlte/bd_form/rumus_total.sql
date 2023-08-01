SELECT (a.real_amount * d.value) as amount , 
(a.real_amount * b.percentage / 100 * d.value) as pph , 
((a.real_amount * d.value)+(a.real_amount * b.percentage / 100 * d.value)) as amount_pph,
(case 
	when (a.id_status_pajak = 1)
	then (10/100) * (a.real_amount * d.value)
	else 0
	end
) as pph
FROM `form_bd_item` a 
left join form_bd_item_pph b on a.id_form_bd_item = b.id_form_bd_item
left join currency c on a.id_currency = c.id_currency
join currency_value d on c.id_currency = d.id_currency
where d.valid_date ='2015-12-01'