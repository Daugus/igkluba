use igkluba;
-- ------------------------------------------------------------------
delimiter //
create trigger recalcular_medias_insert after insert on review
for each row
begin
  declare media_nota float(3, 2) unsigned;
  declare media_edad int(2) unsigned;
  declare cuenta_reviews int unsigned;

  select avg(nota), avg(edad_lector), count(id)
    into media_nota, media_edad, cuenta_reviews
    from review
    where id_libro = NEW.id_libro;

  update libro
  set nota_media = media_nota, edad_media = media_edad, cantidad_reviews = cuenta_reviews
    where id = NEW.id_libro;
end;//
-- ------------------------------------------------------------------
create trigger recalcular_medias_update after update on review
for each row
begin
  declare media_nota float(3, 2) unsigned;
  declare media_edad int(2) unsigned;
  declare cuenta_reviews int unsigned;

  select avg(nota), avg(edad_lector), count(id)
    into media_nota, media_edad, cuenta_reviews
    from review
    where id_libro = NEW.id_libro;

  update libro
  set nota_media = media_nota, edad_media = media_edad, cantidad_reviews = cuenta_reviews
    where id = NEW.id_libro;
end;//
-- ------------------------------------------------------------------
create trigger recalcular_medias_delete after delete on review
for each row
begin
  declare media_nota float(3, 2) unsigned;
  declare media_edad int(2) unsigned;
  declare cuenta_reviews int unsigned;

  select avg(nota), avg(edad_lector), count(id)
    into media_nota, media_edad, cuenta_reviews
    from review
    where id_libro = OLD.id_libro;

  update libro
  set nota_media = media_nota, edad_media = media_edad, cantidad_reviews = cuenta_reviews
    where id = OLD.id_libro;
end;//
delimiter ;