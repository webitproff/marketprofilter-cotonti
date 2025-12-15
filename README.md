# Product filter **"Market PRO Filter"**  

Flexible product filtering in category lists by individual parameters or characteristics.  
Properties for selection can be common for all products or class-based—for a specific category.  
Field types: `select`, `radio`, `checkbox`, and `range`.  
Parameter names and their values used for filtering are specified in the plugin admin panel, and each supports multilingualism. When editing a product, we mark the required characteristic values of existing parameters for filtering.  
Parameter names can be generic for all products, as well as specialized (class-based).


<img src="https://raw.githubusercontent.com/webitproff/marketprofilter-cotonti/refs/heads/main/Market-PRO-product-filter-plugin-Cotonti-by-webitproff.webp" alt="Market PRO Filter plugin Cotonti CMF by webitproff">

---
# [Demo](https://abuyfile.com/ru/market/cotonti/plugs)
# [Support](https://abuyfile.com/forums/cotonti/custom/plugs/marketprofilter)
# [Source code on GitHub](https://github.com/webitproff/marketprofilter-cotonti)

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

