INSTALL
=======

* git clone
* composer install
* bin/console doctrine:database:create
* bin/console doctrine:migrations:migrate
* bin/console server:run
* open http://127.0.0.1:8000

TIMESHEET
=========
* установка symfony + настройка fos user bundle - 20 min
* выбор библиотеки для api + entity portfolio + stock + crud для portfolio - 25 min
* коллекция stock для portfolio php+ js - 25 min
* настройка cascade для коллекции + разбирательства с api - 25 min
* получение данных из апи для каждого stock - 20 min
* выбор библиотеки для графиков - 25min
* класс для обработки полученных данных и вывод на график - 25 min
* css фреймворк для приятного внешнего вида - 25 min

TODO
====
* обработка ошибок в формах (проверка дублирования тикеров, его существования)
* убрать из кода жесткую привязку к 2 годам
* не самое лучшше решение в цикле запрашивать данные от api
* разобраться в финансовой терминологии и округлении данных
* и тд...