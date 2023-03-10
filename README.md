# ToDoListBot
ВК-бот для управления ToDo листами, написанный в рамках курса по веб-разработке от ВК.

![image](https://user-images.githubusercontent.com/69761681/212933113-2d2b8d8f-993b-4418-82dc-398e67a52484.png)

## Использованные технологии
* PHP 8.1
* MySQL
* Nginx
* Docker

## Реализованные команды

| Полная форма | Короткая форма | Обязательные параметры | Описание                             |
|--------------|----------------|------------------------|--------------------------------------|
| /menu        | /m             | Нет                    | Возвращает список возможных команд   |
| /create      | /c             | Описание задачи        | Создает новую задачу                 |
| /done        | /d             | Идентификатор задачи   | Отмечает задачу как выполненную      |
| /remove      | /r             | Идентификатор задачи   | Безвозвратно удаляет задачу          |
| /list        | /l             | Нет                    | Возвращает список невыполненых задач |
| /list-all    | /la            | Нет                    | Возвращает список всех задач         |

### Примеры пользовательских команд
* /m 
* /c моя первая задача
* /d 1
* /r 1
## Команды и возможные ответы при их вызове
## /menu, /m
> Передает пользователю список возможных команд.
### Возможные варианты ответа
| Текст ответа                               | Условие                                            |
|--------------------------------------------|----------------------------------------------------|
| ***список команд***                        | Список передан успешно                             |
| небольшие проблемы с базой данных          | Ошибка на стороне БД                               |
| Произошла непредвиденная ошибка на сервере | Произошла ошибка, которую не перехватил обработчик |
* Ошибка с БД при вводе этой команды может произойти в процессе сохранения пользователя.

## /create, /c {описание}
> Создает новую задачу.
- Описание задачи обязательно.

### Возможные варианты ответа
| Текст ответа                               | Условие                                            |
|--------------------------------------------|----------------------------------------------------|
| задача успешно сохранена. id = ***{id}***  | Успешное создание                                  |
 | вы не задали описание задачи               | Неверный пользовательский ввод                     |
| небольшие проблемы с базой данных          | Ошибка на стороне БД                               |
| Произошла непредвиденная ошибка на сервере | Произошла ошибка, которую не перехватил обработчик |

## /done, /d {id}
> Отмечает задачу как выполненную.
- Идентификатор задачи обязателен.
### Возможные варианты ответа
| Текст ответа                               | Условие                                                                  |
|--------------------------------------------|--------------------------------------------------------------------------|
| задача успешно отмечена как выполненная    | Статус задачи был изменен успешно                                        |
| задача с id = ***{id}*** уже выполнена     | Задача с переданным идентификатор уже была омечена как выполненная ранее |
| задачи с id = ***{id}*** не существует     | Задача с переданным идентификатором не была найдена в БД                 |
| небольшие проблемы с базой данных          | Ошибка на стороне БД                                                     |
| Произошла непредвиденная ошибка на сервере | Произошла ошибка, которую не перехватил обработчик                       |

## /remove, /r {id}
> Безвозвратно удаляет задачу.
- Идентификатор задачи обязателен.
### Возможные варианты ответа
| Текст ответа                               | Условие                                                                  |
|--------------------------------------------|--------------------------------------------------------------------------|
| задача успешно удалена                     | Успешное удаление                                                        |
| задачи с id = ***{id}*** не существует     | Задача с переданным идентификатором не была найдена в БД                 |
| небольшие проблемы с базой данных          | Ошибка на стороне БД                                                     |
| Произошла непредвиденная ошибка на сервере | Произошла ошибка, которую не перехватил обработчик                       |

## /list, /l
> Возвращает список незавершенных задач пользователя.
### Возможные варианты ответа
| Текст ответа                               | Условие                                                  |
|--------------------------------------------|----------------------------------------------------------|
| невыполненных задач пока нет               | У пользователя нет незавершенных задач                   |
| ***список задач пользователя***            | У пользователя есть незавершенные задачи                 |
| небольшие проблемы с базой данных          | Ошибка на стороне БД                                     |
| Произошла непредвиденная ошибка на сервере | Произошла ошибка, которую не перехватил обработчик       |

## /list-all, /la
> Возвращает список всех задач пользователя.
### Возможные варианты ответа
| Текст ответа                               | Условие                                            |
|--------------------------------------------|----------------------------------------------------|
| задач пока нет                             | У пользователя нет задач                           |
| ***список задач пользователя***            | У пользователя есть задачи                         |
| небольшие проблемы с базой данных          | Ошибка на стороне БД                               |
| Произошла непредвиденная ошибка на сервере | Произошла ошибка, которую не перехватил обработчик |
