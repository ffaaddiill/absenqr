select channel.id_channel as channel_id, max(case when package.id_package='1' then 1 else 0 end) as big_universe, max(case when package.id_package='2' then 1 else 0 end) as big_star, max(case when package.id_package='3' then 1 else 0 end) as big_sun, max(case when package.id_package='4' then 1 else 0 end) as big_fun, max(case when package.id_package='5' then 1 else 0 end) as big_deal from channel left join channel_category on channel_category.id_channel_category=channel.id_channel_category left join package_channel on package_channel.id_channel=channel.id_channel left join package on package.id_package=package_channel.id_package group by channel_category.category_name, channel.name  as channel_all