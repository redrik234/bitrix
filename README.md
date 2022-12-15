# Тестовое задание(Bitrix)

## Задание 1: Изменение данных в письме

- Реализовать установку данных отсылаемых в письме по почтовому событию FEEDBACK_FORM, после заполнения формы, создаваемой компонентом bitrix:main.feedback;
- Для проверки работы решения создать раздел сайта /feedback/, добавить пункт в главное меню «Задание 1», и пункт в левом меню «Форма обратной связи»;
- Создание нового компонента, типа почтового события или почтового шаблона - будет неверным решением, должны использоваться типовые;
-	Макрос #AUTHOR# должен получить значение
    >	Если пользователь не авторизован: «Пользователь не авторизован, данные из формы: Имя пользователя». Где Имя пользователя – значение из соответствующего поля формы;
    >	Если пользователь авторизован: «Пользователь авторизован: id (логин) имя, данные из формы: Имя пользователя». Где id, логин, имя – данные пользователя в системе, Имя пользователя – значение из соответствующего поля формы
-	Добавлять запись в журнал событий: «Замена данных в отсылаемом письме – [AUTHOR]». Где [AUTHOR] - это данные макроса AUTHOR подставленного в письмо.
## Задание 2: Разработать простой компонент «Каталог товаров»

**Общие требования**
-	У созданного компонента задать код: simplecomp.catalog, название: «Мой компонент», раздел для отображения компонента в визуальном редакторе: «Задание 2»;
-	Работу решения продемонстрировать в разделе сайта /simplecomp/, добавить пункт в главное меню «Задание 2», и пункт в левом меню «Простой компонент».

**Решаемая задача**
-	Компонент должен выводить список товаров, сгруппированных по альтернативному классификатору. Альтернативный классификатор – новости;
-	Будет использоваться множественная привязка разделов каталога товаров к альтернативному классификатору – новостям. Привязка элементов к разделам в инфоблоке Продукция остается по умолчанию, задавать множественную - не нужно;
-	Используется только один уровень разделов, вложенности – не будет;
-	Большой объем разделов и элементов не предполагается (не более 20 разделов и 100 элементов), лимиты на выборку и постраничная навигация – не нужны.

**Технические требования**
-	Использовать при решении метод GetMixedList – нельзя.
-	Компонент должен иметь только такие параметры:
    >	ID инфоблока с каталогом товаров, строка;
    >	ID инфоблока с новостями, строка;
    >	Код пользовательского свойства разделов каталога, в котором хранится привязка к новостям, строка;
    >	Типовые настройки кеширования: авто+управляемое, кешировать, не кешировать, и время кеширования;
    >	Выбор шаблона.
-	Условия кеширования результата работы компонента - по умолчанию, не зависит от дополнительных данных.

**Инфоблоки, получаемые данные**
-	Использовать существующий информационный блок Продукция.
-	У разделов в инфоблоке Продукция создать множественное пользовательское свойство: код UF_NEWS_LINK, тип – привязка к элементам инфоблока, инфоблок – новости.
-	Каждому разделу в инфоблоке Продукция задать привязку к нескольким новостям. (для возможности отображения пользовательских полей в списке – настройте инфоблок на раздельный просмотр разделов и элементов).
-	Используемые в шаблоне данные разделов каталога товаров:
    >	Поля: название.
-	Используемые в шаблоне данные элементов:
    >	Поля: название.
    >	Свойства: материал, артикул, цена.
-	Используемые в шаблоне данные новостей:
    >	Поля: название, дата активности.
-	Должны выбираться только активные разделы и элементы из обоих инфоблоков.
-	Сортировка при отборе не задается.

**Установка заголовка страницы**
-	В компоненте устанавливать заголовок страницы: «В каталоге товаров представлено товаров: [Количество]» где Количество – количество отображаемых товаров;
-	Заголовок должен устанавливаться в файле component.php. Этот функционал является логикой компонента и не должен «теряться» при смене шаблона.

**Отображение данных**
-	Строится дерево разделов альтернативного классификатора и элементов, относящихся к нему;
-	Рядом с названием альтернативного классификатора отображаются:
    >	Дата активности;
    >	Название связанных разделов каталога.
