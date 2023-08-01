select a.form_id,sum(a.amount) as total_amount,sum(b.total_pph) as total_pph, sum(b.total_ppn) as total_ppn, sum(a.amount-b.total_pph+b.total_ppn) as total_after_cut_pph from 
(select distinct form_id,id_form_bd_item,amount from (SELECT a.id_form_bd as form_id ,a.id_form_bd_item,(a.real_amount * d.value) as amount , 
(a.real_amount * b.percentage / 100 * d.value) as pph 

FROM `form_bd_item` a 
left join form_bd_item_pph b on a.id_form_bd_item = b.id_form_bd_item
left join currency c on a.id_currency = c.id_currency
join currency_value d on c.id_currency = d.id_currency
where d.valid_date ='2015-12-01' and a.id_form_bd = 1) as table_ahay) a 
inner join (select form_id,id_form_bd_item , sum(pph)  as total_pph , sum(ppn) as total_ppn  from (SELECT a.id_form_bd as form_id ,a.id_form_bd_item,(a.real_amount * d.value) as amount , 
(a.real_amount * b.percentage / 100 * d.value) as pph ,
(case when (a.id_status_pajak = 1) then (10/100) * (a.real_amount * d.value) else 0 end ) as ppn

FROM `form_bd_item` a 
left join form_bd_item_pph b on a.id_form_bd_item = b.id_form_bd_item
left join currency c on a.id_currency = c.id_currency
join currency_value d on c.id_currency = d.id_currency
where d.valid_date ='2015-12-01' and a.id_form_bd = 1) as tabel_pph
group by id_form_bd_item) b on a.form_id = b. form_id and a.id_form_bd_item = b.id_form_bd_item

