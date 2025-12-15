# Product filter **"Market PRO Filter"**  

## 🇬🇧  Flexible product filtering in category lists by individual parameters or characteristics.  

Properties for selection can be common for all products or class-based—for a specific category.  
Field types: `select`, `radio`, `checkbox`, and `range`.  
Parameter names and their values used for filtering are specified in the plugin admin panel, and each supports multilingualism. When editing a product, we mark the required characteristic values of existing parameters for filtering.  
Parameter names can be generic for all products, as well as specialized (class-based).

[![License](https://img.shields.io/badge/license-BSD-blue.svg)](https://github.com/webitproff/marketprofilter-cotonti/blob/main/LICENSE)
[![Version](https://img.shields.io/badge/version-2.2.1-green.svg)](https://github.com/webitproff/marketprofilter-cotonti/releases)
[![Cotonti Compatibility](https://img.shields.io/badge/Cotonti_Siena-0.9.26-orange.svg)](https://github.com/Cotonti/Cotonti)
[![PHP](https://img.shields.io/badge/PHP-8.4-blueviolet.svg)](https://www.php.net/releases/8_4_0.php)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-blue.svg)](https://www.mysql.com/)

<img src="https://raw.githubusercontent.com/webitproff/marketprofilter-cotonti/refs/heads/main/Market-PRO-product-filter-plugin-Cotonti-by-webitproff.webp" alt="Market PRO Filter plugin Cotonti CMF by webitproff">

---
### [Demo](https://abuyfile.com/ru/market/cotonti/plugs)
### [Support](https://abuyfile.com/forums/cotonti/custom/plugs/marketprofilter)
### [Source code on GitHub](https://github.com/webitproff/marketprofilter-cotonti)
### [Releases](https://github.com/webitproff/marketprofilter-cotonti/releases)
---
## Examples

### 1. Common parameters

**1.1. Parameter name (value group name)** — *Delivery Methods*  
Such parameters are not bound to any specific category and apply to all products in the catalog.

**1.2. Parameter values**: *Self pickup*, *Courier*, *SuperDelivery Transport Company*

Resulting structure:

```text
/Common parameters/     # such parameters are not assigned to a specific category
│
├── Delivery methods/            # 1st parameter (value group name)
│   ├── Self pickup                  # 1st value/property
│   ├── City courier                 # 2nd value/property
│   ├── Carrier pigeon               # 3rd value/property
│   ├── Airmail Crash Lines          # 4th value/property
│   └── SuperDelivery transport company  # 5th value/property
│
├── Country of manufacture/       # 2nd parameter (value group name)
│   ├── Domestic manufacturer          # 1st value/property
│   ├── China                          # 2nd value/property
│   ├── Taiwan                         # 3rd value/property
│   ├── India                          # 4th value/property
│   └── Turkey                         # 5th value/property
```

---

### 2. Class-based parameters

Here, the term *class-based* refers to product classification within a specific category.  
Within that category, a product has a set of characteristic group names, as well as names and values of properties by which it is classified.

Let us take the **Laptops** category as an example.

**2.1. Parameter name (value group name)** — *Brand/Manufacturer*  
Similarly, we create value groups such as: *RAM Capacity*, *SSD Capacity (Storage)*, *Screen Diagonal*, *Processor Family*, *Processor Generation*, *Video Memory*, etc.

**2.2. Parameter values**  
Within our class (laptops), each characteristic group has its own set of values inherent to each laptop, and these values are used for filtering in the product list.

Schematic structure:

```text
/Class-based parameters/     # parameters assigned to a specific category — laptops
│
├── Brand/Manufacturer /
│   ├── Lenovo
│   ├── ASUS
│   ├── DELL
│   ├── MSI
│   └── Samsung
│
├── RAM Capacity /
│   ├── less than 4 GB
│   ├── 4 GB
│   ├── 8 GB
│   ├── 16 GB
│   ├── 32 GB
│   └── more than 32 GB
│
├── SSD Capacity (Storage) /
│   ├── less than 128 GB
│   ├── 128 GB
│   ├── 246 GB
│   ├── 512 GB
│   └── more than 512 GB
│
├── GPU Video Memory /
│   ├── Integrated in CPU
│   └── Discrete
```

Thus, we can see how the filter structure is built for a specific classification within a category, and that general-purpose parameters can also be applied.

---

## 3. Basics of product filter operation

### 3.1 Category requirement

The **Market PRO** product module requires specifying a category when publishing a product.

At the same time, the module allows retrieving a product list without selecting a category—the main catalog.  
This is a significant advantage of the module within the Cotonti CMF engine. For example, OpenCart CMS does not support this approach.  
This is also beneficial for SEO, as a single link can provide search engines with access to new content.

---

### 3.2 Product filtering without categories (common parameters)

In the product catalog, under the category list or in any convenient place, we place the filter block.  
Until a category is selected, filtering is available only by common parameters.

Previously discussed examples include *Delivery Methods* and *Country of Manufacture*. In a marketplace, you might add a *Seller* group with local sellers or retail chains. Characteristic groups can be arbitrary: *promotion*, *discounted*, *product condition*, *unique product*, etc.

**Example product**:  
A laptop that is new, with a metal case replacing a plastic one at the seller’s request, individual engraving, manufactured in Taiwan, and delivered via *SuperDelivery*.

#### Filtering results

**3.2.1**  
`[New product] + [Unique product] + [Taiwan] + [SuperDelivery]`  
→ The laptop appears in the catalog.

**3.2.2**  
`[New product] + [Unique product]`  
→ The laptop also appears in the results.

**3.2.3**  
`[New product] + [Unique product] + [Taiwan] + [Airmail Crash Lines]`  
→ The laptop does **not** appear.

---

### Why the product was excluded

Only products that have the selected parameter values appear in filter results.  
The laptop does not have the value *Airmail Crash Lines*, therefore it is excluded.

Filtering logic:

- `a + b` → the product has both values `(a + b)`
- `a + b + c` → the product has all three values `(a + b + c)`
- `a + b + c + d` → the product has all four values `(a + b + c + d)`

---

## Filtering logic visualization

```text
+-----------------------------------------+
| Product                                 |
+-----------------------------------------+
         │
         ▼
  Different filters (filter_*)
  ┌─────────────┬─────────────┐
  │ filter_color│ filter_size │ ...
  └─────────────┴─────────────┘
         │
         │  Logic: AND
         ▼
  Product must match ALL filters
         │
         ▼
  Within one parameter:
  ┌───────────────────────────┐
  │ checkbox: red, blue       │
  └───────────────────────────┘
         │
         │  Logic: OR
         ▼
  At least one value matches
         │
         ▼
  Select / Radio / Range
  (single value or range)
         │
         │  Logic: AND for range
         ▼
  Condition met or not
         │
         ▼
+-----------------------------------------+
| Included in final selection?            |
| - Yes: all AND conditions are met       |
| - No: any condition fails or parameter  |
|   does not belong to the product        |
+-----------------------------------------+
```

---

**Market PRO Filter** is a simple and intuitive product filter plugin for **Cotonti CMF**, supporting multilingual parameter and value names, and offering high flexibility for use across different product and service categories.
```
/**
 * Market PRO Filter plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0+
 * Date=2025-12-14
 * @package marketprofilter
 * @version 2.2.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 https://github.com/webitproff/
 * @license BSD
 */
```
---


# 🇷🇺 Фильтр товаров **«Market PRO Filter»**  
Гибкая фильтрация товаров в списках категорий по индивидуальным параметрам и характеристикам.  
Параметры выборки могут быть общими для всех товаров либо классовыми — для конкретной категории.  
Типы полей: `select`, `radio`, `checkbox`, `range`.  
Названия параметров и их значения, по которым выполняется фильтрация, задаются в административной панели плагина и поддерживают мультиязычность. При редактировании товара выбираются необходимые значения характеристик существующих параметров для фильтрации.  
Названия параметров могут быть как общими для всех товаров, так и профильными (классовыми).

---

## Примеры

### 1. Общие параметры

**1.1. Название параметра (имя группы значений)** — *Способы доставки*  
Такие параметры не привязываются к конкретной категории и применяются ко всем товарам каталога.

**1.2. Значения параметра**: *Самовывоз*, *Курьер*, *Транспортная компания SuperDelivery*

Итоговая структура:

```text
/Общие параметры/     # параметры не привязываются к конкретной категории
│
├── Способы доставки/            # 1-й параметр (группа значений)
│   ├── Самовывоз                   # 1-е значение параметра
│   ├── Курьер по городу            # 2-е значение параметра
│   ├── Почтовым голубем            # 3-е значение параметра
│   ├── Авиапочта Crash Lines       # 4-е значение параметра
│   └── Трансп. компания SuperDelivery  # 5-е значение параметра
│
├── Страна производства/         # 2-й параметр (группа значений)
│   ├── Отечественный производитель   # 1-е значение параметра
│   ├── Китай                         # 2-е значение параметра
│   ├── Тайвань                       # 3-е значение параметра
│   ├── Индия                         # 4-е значение параметра
│   └── Турция                        # 5-е значение параметра
```

---

### 2. Классовые параметры

Под термином *классовые параметры* понимается классификация товара в рамках конкретной категории.  
Товар в этой категории имеет набор групповых характеристик, а также имена и значения свойств, по которым он классифицируется.

В качестве примера рассмотрим категорию **«Ноутбуки»**.

**2.1. Название параметра (имя группы значений)** — *Бренд / Производитель*  
Аналогично создаются и другие группы значений, например: *Объём ОЗУ (RAM)*, *Объём SSD (Storage)*, *Диагональ экрана*, *Семейство процессоров*, *Поколение процессора*, *Видеопамять* и т.д.

**2.2. Значения параметров**  
В рамках класса (ноутбуки) каждая группа характеристик имеет собственный набор значений, присущих каждому товару. Эти же значения используются для фильтрации товаров в списке.

Схематично структура выглядит так:

```text
/Классовые параметры/     # параметры привязываются к конкретной категории — ноутбуки
│
├── Бренд / Производитель /
│   ├── Lenovo
│   ├── ASUS
│   ├── DELL
│   ├── MSI
│   └── Samsung
│
├── Объём ОЗУ (RAM) /
│   ├── менее 4 GB
│   ├── 4 GB
│   ├── 8 GB
│   ├── 16 GB
│   ├── 32 GB
│   └── более 32 GB
│
├── Объём SSD (Storage) /
│   ├── менее 128 GB
│   ├── 128 GB
│   ├── 246 GB
│   ├── 512 GB
│   └── более 512 GB
│
├── Видеопамять GPU /
│   ├── Интегрированная в CPU
│   └── Дискретная
```

Таким образом, можно понять, как формируется структура фильтра товаров под конкретную классификацию в рамках одной категории, а также как к таким товарам применяются параметры общего характера.

---

## 3. Основы работы фильтра товаров

### 3.1 Обязательность категории

Модуль товаров **Market PRO** требует указывать категорию при публикации товара.

При этом модуль позволяет получать список товаров и без выбора категории — основной каталог.  
Это является существенным преимуществом движка **Cotonti CMF**. Например, в OpenCart CMS подобная логика отсутствует.  
Дополнительно это даёт преимущество в SEO-оптимизации, когда по одной ссылке поисковая система получает доступ к новому контенту.

---

### 3.2 Фильтрация товаров без учёта категорий (по общим параметрам)

В каталоге товаров, под списком категорий либо в любом удобном месте, размещается блок фильтра.  
До тех пор, пока категория не выбрана, фильтрация доступна только по общим параметрам.

Ранее были рассмотрены примеры *Способы доставки* и *Страна производства*. Для маркетплейсов можно добавить группу *Продавец* со списком локальных продавцов или торговых сетей. Группы характеристик могут быть любыми: *акция*, *уценка*, *состояние товара*, *уникальный товар* и т.д.

**Пример товара:**  
Новый ноутбук, у которого по заказу продавца пластиковый корпус заменён на металлический, выполнена индивидуальная гравировка, страна производства — Тайвань, доставка — *SuperDelivery*.

#### Результаты фильтрации

**3.2.1**  
`[Новый товар] + [Уникальный товар] + [Тайвань] + [SuperDelivery]`  
→ ноутбук отображается в каталоге.

**3.2.2**  
`[Новый товар] + [Уникальный товар]`  
→ ноутбук также присутствует в результатах фильтрации.

**3.2.3**  
`[Новый товар] + [Уникальный товар] + [Тайвань] + [Авиапочта Crash Lines]`  
→ ноутбук отсутствует в результатах.

---

### Почему товар был исключён

В результатах фильтрации отображаются только те товары или услуги, которые имеют выбранные значения параметров.  
В данном случае у ноутбука отсутствует значение *Авиапочта Crash Lines*, поэтому он был исключён.

Логика фильтрации:

- `a + b` → товар имеет оба значения `(a + b)`
- `a + b + c` → товар имеет все три значения `(a + b + c)`
- `a + b + c + d` → товар имеет все четыре значения `(a + b + c + d)`

---

## Схема логики фильтра

```text
+-----------------------------------------+
| Товар                                   |
+-----------------------------------------+
         │
         ▼
  Разные фильтры (filter_*)
  ┌─────────────┬─────────────┐
  │ filter_color│ filter_size │ ...
  └─────────────┴─────────────┘
         │
         │  Логика: AND («И»)
         ▼
  Товар должен соответствовать
  ВСЕМ выбранным фильтрам
         │
         ▼
  Внутри одного параметра:
  ┌───────────────────────────┐
  │ checkbox: красный, синий  │
  └───────────────────────────┘
         │
         │  Логика: OR («ИЛИ»)
         ▼
  Подходит хотя бы одно значение
         │
         ▼
  Select / Radio / Range
  (одно значение или диапазон)
         │
         │  Логика: AND для диапазона
         ▼
  Условие выполнено или нет
         │
         ▼
+-----------------------------------------+
| Входит в итоговую выборку?               |
| - Да: выполнены все условия AND          |
| - Нет: хотя бы одно условие не выполнено |
|   или параметр не принадлежит товару    |
+-----------------------------------------+
```

---

**Market PRO Filter** — это простой и наглядный плагин фильтра товаров для **Cotonti CMF**, поддерживающий мультиязычные названия групп характеристик и значений, а также обладающий высокой гибкостью применения в различных категориях товаров и услуг.



