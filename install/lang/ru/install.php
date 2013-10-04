<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Automatically generated strings for Moodle installer
 *
 * Do not edit this file manually! It contains just a subset of strings
 * needed during the very first steps of installation. This file was
 * generated automatically by export-installer.php (which is part of AMOS
 * {@link http://docs.moodle.org/dev/Languages/AMOS}) using the
 * list of strings defined in /install/stringnames.txt.
 *
 * @package   installer
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['admindirname'] = 'Каталог администратора';
$string['availablelangs'] = 'Доступные языковые пакеты';
$string['chooselanguagehead'] = 'Выберите язык';
$string['chooselanguagesub'] = 'Сейчас необходимо выбрать язык ТОЛЬКО для сообщений во время установки. Язык сайта и пользовательских интерфейсов можно будет указать далее в процессе установки.';
$string['clialreadyconfigured'] = 'Файл config.php уже существует. Если Вы хотите установить этот сайт, используйте admin/cli/install_database.php.';
$string['clialreadyinstalled'] = 'Файл config.php уже существует. Если Вы хотите обновить сайт, то используйте скрипт admin/cli/upgrade.php.';
$string['cliinstallheader'] = 'Программа установки Moodle {$a} в режиме командной строки';
$string['databasehost'] = 'Сервер баз данных';
$string['databasename'] = 'Название базы данных';
$string['databasetypehead'] = 'Выберите драйвер базы данных';
$string['dataroot'] = 'Каталог данных';
$string['datarootpermission'] = 'Разрешения на каталоги данных';
$string['dbprefix'] = 'Префикс имён таблиц';
$string['dirroot'] = 'Каталог Moodle';
$string['environmenthead'] = 'Проверка среды...';
$string['environmentsub2'] = 'У каждой версии Moodle есть минимальные требования к версии PHP и набор обязательных расширений PHP.
Полная проверка среды осуществляется перед каждой установкой и обновлением.
Пожалуйста, свяжитесь с администратором сервера, если не знаете, как установить новую версию или включить расширения PHP.';
$string['errorsinenvironment'] = 'Проверка окружения не выполнена!';
$string['installation'] = 'Установка';
$string['langdownloaderror'] = 'К сожалению, не удалось установить язык "{$a}". Процесс установки продолжится на английском.';
$string['memorylimithelp'] = '<p>Сейчас ограничение памяти в PHP на Вашем сервере установлено в {$a}.</p>

<p>Из-за этого у через какое-то время у Moodle могут возникнуть проблемы с памятью, особенно если у Вас будет много модулей и/или пользователей.</p>

<p>Мы рекомендуем, если возможно, установить в PHP более высокое ограничение памяти, например 40M.
Это можно попробовать сделать следующими способами:</p>
<ol>
<li>Если есть возможность, перекомпилируёте PHP с ключом <i>--enable-memory-limit</i>.
В этом случае Moodle сможет самостоятельна установить ограничение памяти.</li>
<li>Если у Вас есть доступ к файлу php.ini, Вы можете изменить параметр <b>memory_limit</b>
на что-нибудь типа 40M. Если доступа у Вас нет, может быть у Вас есть возможность попросить администратора сделать это.</li>
<li>На некоторых серверах PHP можно создать в каталоге Moodle файл .htaccess содержащий следующую строку:
<blockquote><div>php_value memory_limit 40M</div></blockquote>
<p>Тем не менее, на некоторых серверах из-за этого могут перестать работать <b>все</b> страницы PHP (Вы увидите ошибки на страницах). В этом случае файл придётся удалить файл .htaccess.</p></li>
</ol>';
$string['paths'] = 'Пути';
$string['pathserrcreatedataroot'] = 'Программа установки  не может создать каталог данных ({$a->dataroot}).';
$string['pathshead'] = 'Подтвердите пути';
$string['pathsrodataroot'] = 'Каталог данных недоступен для записи.';
$string['pathsroparentdataroot'] = 'Родительский каталог ({$a->parent}) не доступен для записи. Программа установки не может создать каталог данных ({$a->dataroot}).';
$string['pathssubadmindir'] = 'На небольшом числе веб-хостингов путь /admin используется для доступа к панели управления или чему-то еще. К сожалению, это противоречит стандартному расположению страниц управления Moodle. Это можно исправить путем переименования папки admin в каталоге Moodle и указания нового имени здесь. Например: <em>moodleadmin</em>. При этом все ссылки на панель управления Moodle исправятся автоматически.';
$string['pathssubdataroot'] = 'Необходимо указать место, где Moodle будет хранить загружаемые файлы. Этот каталог должен быть доступен для чтения и ЗАПИСИ тому пользователю, от чьего имени запускается веб-сервер (обычно \'nobody\' или \'apache\'), но при этом не должен быть доступен напрямую через Интернет. Программа установки попробует создать этот каталог, если он не существует.';
$string['pathssubdirroot'] = 'Полный путь к каталогу установки Moodle.';
$string['pathssubwwwroot'] = 'Полный веб-адрес, по которому будет доступен Moodle.
Использовать для доступа к Moodle несколько публичных адресов невозможно.
Если у вашего сайта есть еще несколько публичных адресов, вам следует настроить постоянные перенаправления с этих адресов на указанный.
Если ваш сайт доступен как из Интернета, так и из локальной сети, укажите здесь публичный адрес и настройте DNS таким образом, чтобы этот адрес был доступен и локальным пользователям.
Если указанный здесь адрес неверный, измените URL в строке адреса браузера, чтобы перезапустить установку с другим значением.';
$string['pathsunsecuredataroot'] = 'Расположение каталога данных не отвечает требованиям безопасности';
$string['pathswrongadmindir'] = 'Каталог admin не существует';
$string['phpextension'] = 'Расширение PHP "{$a}"';
$string['phpversion'] = 'Версия PHP';
$string['phpversionhelp'] = '<p>Для Moodle необходим PHP версии 4.3.0 и выше или 5.1.0 и выше (известны некоторые проблемы с версией 5.0.x).</p>
<p>Сейчас у Вас используется версия {$a}</p>
<p>Вам нужно обновить PHP или переместиться на хостинг с более новой версией PHP!<br />
(В случае с версией 5.0.x можно также откатиться к версии 4.4.x)</p>';
$string['welcomep10'] = '{$a->installername} ({$a->installerversion})';
$string['welcomep20'] = 'Вы видите эту страницу, потому что успешно установили и запустили на своем компьютере набор программ <strong>{$a->packname} {$a->packversion}</strong>. Поздравляем!';
$string['welcomep30'] = 'Эта версия набора программ <strong>{$a->installername}</strong> включает следующие программы, необходимые для создания среды, в которой будет работать <strong>Moodle</strong>:';
$string['welcomep40'] = 'Также в этот набор входит <strong>Moodle {$a->moodlerelease} ({$a->moodleversion})</strong>.';
$string['welcomep50'] = 'Порядок использования приложений, входящих в этот набор, регламентируется соответствующими лицензиями. Набор программ <strong>{$a->installername}</strong> является полностью <a href="http://ru.wikipedia.org/wiki/Открытое_программное_обеспечение">открытым </a> и распространяется на условиях лицензии <a href="http://www.gnu.org/copyleft/gpl.html">GPL</a>.';
$string['welcomep60'] = 'На следующих страницах Вы сможете за несколько простых шагов настроить и установить <strong>Moodle</strong> на свой компьютер. Вы сможете принять настройки по умолчанию или изменить их в зависимости от своих потребностей.';
$string['welcomep70'] = 'Нажмите кнопку "Далее" чтобы продолжить процесс установки <strong>Moodle</strong>.';
$string['wwwroot'] = 'Веб-адрес';
