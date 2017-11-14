A feladat egy egyszerű Todo alkalmazás. (hozzávetőleg 4, de maximum 6 óra)

A feladatot Laravel kertrendszerben készítsd!


- Regisztráció, bejelentkezés (belépett user kezel mindent)
- Feladat létrehozása user alá.
    - Feladat mezőí:
        - cím (kötelező mező)
        - leírás (opcionális)
        - időpont (eltelt idő formában pl.: 1 napja, 2 órája) - automatikus
        - elvégzett - alapértelmezetten: 0
    - Az adatok legyenek szerver oldalon validálva!
- Feladat módosításának lehetősége (ajax mentés)
- Feladat törlés (ajax)
- Feladat elvégzettnek jelölése (ajax)
- Szabad szavas keresés feladatok között (címben és leírásban).
- Listázás: legújabbak elől, az elvégzettek a lista végén, az elvégzettnek jelölés időpontja szerint csökkenő sorrendben.
- Az elvégzett feladatokat lehessen elrejteni/megjeleníteni. Ezt az állapotot a rendszer tárolja sütiben, és következő látogatás alkalmával ennek függvényében mutassa az elvégzett feladatokat.

Laraveles megkötések (ha nem dolgoztál még Laravelben ezek nem kötelezőek, de jó, ha tudod használni őket):

- Laravel 5.4 (esetleg 5.3)
- Eloquent ORM használata
- Időkezeléshez Carbon használata
- Belépés, regisztráció artisan auth-al menjen (auth generálás).
- Asset (css, js) kezeléshez, ha tudsz használj Mix-et, Laravel 5.4 alatt Elixir-t.
- Adatbázis migrációs fájlok
- Seed egy userrel és hozzá tartozó két feladattal melyből az egyik elvégzett.

Külcsín nem számít, lehetőleg használj Bootstrap 3-at, ajax hívásokhoz jQuery 3-at.

A feladat legyen feltöltve Github-ra vagy Bitbucket-re egy nyilvános repositoryba.


TODOS, illetve megjegyzések:
- a task-ok title mezőjét nem unique-ként vettem fel, ez koncepció volt
- a formokat a szűk határidőre tekintettel sima html tag-ekkel csináltam, erre vannak szebb megoldások laravel-ben (Form osztály, Blade helperek, stb.)
- az aktuális verziójú homestead alól futtattam (laravel 5.4, php 7.1), sqlite adatbázissal
