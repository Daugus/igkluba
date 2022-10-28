use igkluba;
-- ----------------------------------------------------------------
-- trigger medias
delimiter //
create trigger recalcular_medias_insert
after
insert on review for each row begin
  declare media_nota float(3, 2) unsigned;
  declare media_edad int(2) unsigned;
  declare cuenta_reviews int unsigned;
  select avg(nota),
    avg(edad_lector),
    count(id) into media_nota,
    media_edad,
    cuenta_reviews
  from review
  where id_libro = NEW.id_libro;
  update libro
  set nota_media = media_nota,
    edad_media = media_edad,
    cantidad_reviews = cuenta_reviews
  where id = NEW.id_libro;
end;
//
-- ------------------------------------------------------------------
create trigger recalcular_medias_update
after
update on review for each row begin
  declare media_nota float(3, 2) unsigned;
  declare media_edad int(2) unsigned;
  declare cuenta_reviews int unsigned;
  select avg(nota),
    avg(edad_lector),
    count(id) into media_nota,
    media_edad,
    cuenta_reviews
  from review
  where id_libro = NEW.id_libro;
  update libro
  set nota_media = media_nota,
    edad_media = media_edad,
    cantidad_reviews = cuenta_reviews
  where id = NEW.id_libro;
end;
//
-- ------------------------------------------------------------------
create trigger recalcular_medias_delete
after delete on review for each row begin
  declare media_nota float(3, 2) unsigned;
  declare media_edad int(2) unsigned;
  declare cuenta_reviews int unsigned;
  select avg(nota),
    avg(edad_lector),
    count(id) into media_nota,
    media_edad,
    cuenta_reviews
  from review
  where id_libro = OLD.id_libro;
  update libro
  set nota_media = media_nota,
    edad_media = media_edad,
    cantidad_reviews = cuenta_reviews
  where id = OLD.id_libro;
end;
//
-- ------------------------------------------------------------------
-- trigger aceptación de libro
create trigger eliminar_solicitud_libro
after update on libro for each row begin
  if NEW.aceptado = 1 then
    delete from solicitud_libro where id_libro = NEW.id;
  end if;
end;
//
delimiter ;
-- ----------------------------------------------------------------
-- evento caducidad
create event desactivar_cuentas
  on schedule every 1 year starts '2023-06-25 00:00'
  on completion preserve enable
  do update cuenta set activo = false where rol = 'Ikasle' AND activo = true;
