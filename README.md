Oro Fixtures Bundle
===============================================

Description
-----------
This bundle provides an abstract fixture class that can be extended to load Alice fixtures. Providing an easy way to load small subsets of demo/test data for developer environments. These fixtures can then be easily shared with any Behat tests created for your bundles. 

This bundle is not intended to be loaded in production and will only load it's required services in dev mode. 

Installation Instructions
-------------------------
1. Install this module via Composer

        composer require --dev aligent/oro-fixtures

1. Add the below to your `src/AppKernel.php` `registerBundles` function

    ```php
    if (class_exists('Nelmio\Alice\Bridge\Symfony\NelmioAliceBundle')
        && class_exists('Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundle')) {
        $bundles[] = new Nelmio\Alice\Bridge\Symfony\NelmioAliceBundle();
        $bundles[] = new Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundle();
    }
    ```

1. Clear cache
        
        php bin/console cache:clear --env=dev
        
Initializers
------------
Intializers provide a way for Alice fixtures to reference entities that already exist in the database.

This bundle comes with the below initializers:

|Initializer|Description|Example|
|---|---|---|
|AdminUserInitializer|First user with `ROLE_ADMINISTRATOR`|`@admin_user`|
|CustomerUserRoleInitializer|All customer user roles|`@buyer`, `@admin`|
|ProductUnitInitializer|All product unit codes prefixed with `unit`|`@unit_each`|
|RootCategoryInitializer|The master catalogs root category|`@root_category`|
|WarehouseInitializer|The snake case version of the name of each warehouse (Enterprise only) prefixed with `warehouse`|`Some Warehouse` becomes `@warehouse_some_warehouse`|
|BusinessUnitInitializer|All of the existing business units suffixed with `_business_unit`| `North Office` becomes `@north_office_business_unit`|
|DefaultPriceListInitializer|The default price list|`@default_price_list`|
|OrganizationInitializer|If more than one organization exists the normalized name of of the organization prefixed by `org_`. If only one exists it is named `default_organization` |`@default_organization` or `Our Business` becomes `@org_our_business`|
|SegmentTypeInitializer|The available segment types|`@dynamic_segment_type` or `static_segment_type`|
|WebsiteInitializer|All website names prefixed by `website_`|`Some Store` becomes `@website_some_store`|
|CustomerGroupInitializer|All customer group names prefixed with `group_` |`Registered Buyers` becomes `@group_registered_buyers`|
|InventoryStatusInitializer|All inventory status ids prefixed by `inventory_status_`|`@inventory_status_in_stock` or `@inventory_status_out_of_stock`|
|ProductFamilyInitializer|All Attribute family names prefixed with `product_family_`|`Clothing Attributes` becomes `@product_family_clothing_attributes`|
|TaxCodeInitializer|The tax code lowercased and prefixed with `tax_code_`|`GST_FREE` becomes `@tax_code_gst_free`|

Adding and Running Fixtures
-----------
1. Ensure your database has been initialized with an empty installation of OroCommerce (i.e. DO NOT ADD DEMO DATA)

1. Snapshot your database to create a rollback point 
1. In your bundle create the Demo fixture directory e.g. `src/Acme/BaseBundle/Migrations/Data/Demo/ORM`

1. Create a subdirectory called `data` e.g. `src/Acme/BaseBundle/Migrations/Data/Demo/ORM/data` and add an alice fixture e.g.
    ```yaml
    Oro\Bundle\ProductBundle\Entity\ProductName:
        product_A_1_name:
            string: 'Product A 1'

    Oro\Bundle\ProductBundle\Entity\ProductUnitPrecision:
        unit_precisionA1:
            unit: '@unit_each'
            precision: '1'

    Oro\Bundle\ProductBundle\Entity\Product:
        product_A_1:
            type: 'simple'
            sku: 'PROD_A_1'
            organization: '@organization'
            attributeFamily: '@defaultProductFamily'
            primaryUnitPrecision: '@unit_precisionA1'
            __calls:
                - addName: ['@product_A_1_name']
            status: 'enabled'
            inventoryStatus: '@enumInventoryStatuses'

    Oro\Bundle\PricingBundle\Entity\ProductPrice:
        price_A_1:
            product: '@product_A_1'
            priceList: '@defaultPriceList'
            currency: 'AUD'
            quantity: 1
            unit: '@unit_each'
            value: 12

    Oro\Bundle\PricingBundle\Entity\PriceListToProduct:
        priceRelation_A_1:
            product: '@product_A_1'
            priceList: '@defaultPriceList'
    ```
1. In the demo fixtures directory create a new fixture that extends the `AbstractAliceFixture` and implement the `getFixtures`. This can point to a single file or a directory of yml files.
    ```php
    <?php

    namespace Acme\BaseBundle\Migrations\Data\Demo\ORM;

    use Aligent\FixturesBundle\Fixtures\AbstractAliceFixture;

    class ExampleDemoDataFixture extends AbstractAliceFixture
    {
        protected function getFixtures(): string
        {
            return __DIR__ . '/data';
        }
    }

    ```
1. To execute the fixtures run:
    ```bash
        bin/console oro:migration:data:load --env=dev --fixtures-type=demo --bundles=AcmeBaseBundle --bundles=AcmeAnotherBundle
    ```


Support
-------
If you have any issues with this bundle, please feel free to open [GitHub issue](https://github.com/aligent/oro-fixtures/issues) with version and steps to reproduce.

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Adam Hall <adam.hall@aligent.com.au>.

License
-------
[GPLv3](https://opensource.org/licenses/GPL-3.0)

Copyright
---------
(C) 2022 Aligent Consulting
