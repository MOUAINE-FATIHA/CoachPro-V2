 --challenge 1
select u.nom,count(s.id) as totalS,sum(s.statut = 'reservee') as reserver,(sum(s.statut = 'reservee') / count(s.id) * 100) as taux from users u
inner join coachs c on u.id = c.user_id
inner join seances s on c.user_id = s.coach_id
group by u.nom
having count(s.id) >= 3
----------------------------------------------------
--challenge 2
