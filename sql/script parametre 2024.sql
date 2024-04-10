use mdl;
SET SQL_SAFE_UPDATES = 0;
delete from proposer where true;
delete from categoriechambre where true;
delete from hotel where true;
delete from restauration where true;
delete from compte where true;
-- creation hotels et chambres
insert into hotel (id,nom,adresse1,cp,ville,tel,mail) values
(1,"Ibis Styles Lille Centre Gare Beffroi","172 rue Pierre Mauroy","59000","Lille","+33187213710","mail"),
(2,"Ibis Budget Lille Gares Vieux-Lille","10, Rue de Courtrai","59000","Lille","+33187213710","mail");
insert into categoriechambre (id,libellecategorie) values (1,"Single"),(2,"Double");
insert into proposer (categoriechambre_id,hotel_id,tarifnuite) values (1,1,95),(1,2,105),(2,1,70),(2,2,80);

-- creation restaurations
insert into restauration (date_restauration,type_repas) values
('2024-09-07',"midi"),('2024-09-07',"soir"),('2024-09-08',"midi");
-- creation comptes de test
insert into compte (email,roles,password,numlicence,is_verified) values 
('admin@mdl.doney.fr','["ROLE_ADMIN"]','$2y$13$KDureIQswSiPP83jX9ezbu/2ER5o2uTACndetzGBfhl3OjR7inmbe','16620515736','1'),
('inscrit@mdl.doney.fr','["ROLE_INSCRIT"]','$2y$13$W6A4yw40TVYWGgiEM2LxhuMNQUQGLNf2AeWF7ln0Q3yvUYiyZVNP6','16660412463','1');
