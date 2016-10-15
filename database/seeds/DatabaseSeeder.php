<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // IMPORT AREA

        $this->call(ImportPartiesStatusesTableSeeder::class);
        $this->call(ImportIndexSuppliersTableSeeder::class);
        $this->call(ImportIndexCategoriesTableSeeder::class);
        $this->call(ImportIndexPartiesTableSeeder::class);
        $this->call(ImportIndexSalesTableSeeder::class);
        $this->call(ImportPartiesCoincidenceLogTableSeeder::class);
        $this->call(ImportPartiesCoincidenceStatusesTableSeeder::class);
        $this->call(ImportPartiesFileAllocationTableSeeder::class);
        $this->call(ImportPartiesLogDeleteTableSeeder::class);
        $this->call(ImportPartiesLogEditTableSeeder::class);
        $this->call(ImportPartiesPrepareLogTableSeeder::class);
        $this->call(ImportPartiesPrepareStatusesTableSeeder::class);
        $this->call(ImportPartiesWorkLogTableSeeder::class);
        $this->call(ImportPartiesWorkStatusesTableSeeder::class);
        $this->call(ImportSalesAssociationLogTableSeeder::class);
        $this->call(ImportSalesAssociationTableSeeder::class);
        $this->call(ImportSalesLogDeleteTableSeeder::class);
        $this->call(ImportSalesLogEditTableSeeder::class);
        $this->call(ImportPartiesPhotosFoundsTableSeeder::class);

        // END IMPORT AREA

        // START USERS AREA

        $this->call(UsersCategoriesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserIndexCategoriesTableSeeder::class);
        $this->call(RolesTableSeeder::class);

        // END USERS AREA

        $this->call(GenderTableSeeder::class);

        // START NOTIFICATIONS AREA

        $this->call(NotificationsTableSeeder::class);
        $this->call(NotificationsTypesListSeeder::class);
        $this->call(NotificationsIndexSeeder::class);
        $this->call(NotificationsParamsListSeeder::class);
        $this->call(NotificationsLogsSeeder::class);

        // END NOTIFICATIONS AREA

        // START ORDER AREA

        $this->call(DeliveryTypesSeeder::class);
        $this->call(PaymentTypesSeeder::class);
        $this->call(OrderIndexSeeder::class);
        $this->call(OrderContactDetailsSeeder::class);
        $this->call(OrderDeliverySeeder::class);
        $this->call(OrderStatusListTableSeeder::class);

        // END ORDER AREA

        // START INDEX AREA

        $this->call(IndexCategoriesSeeder::class);
        $this->call(IndexStockSeeder::class);
        $this->call(UsersCategoriesSalesSeeder::class);

        // END INDEX AREA

        // PRODUCT AREA
        $this->call(ProductBrandsSeeder::class);
        $this->call(ProductIndexSeeder::class);

        // END PRODUCT AREA

        // START ADDITIONAL INDEX

        $this->call(IndexDiscountTableSeeder::class);
        $this->call(CouponRulesTableSeeder::class);
        $this->call(CouponTableSeeder::class);
        $this->call(DiscountUserCategoriesTableSeeder::class);
        $this->call(DiscountUserTableSeeder::class);
        $this->call(ProductIndexPriceTableSeeder::class);
        $this->call(UsersBonusesTableSeeder::class);
        //$this->call(BonusesTypeSeeder::class);
        //$this->call(UsersBonusesLogSeeder::class);
        $this->call(UserBalanceSeeder::class);

        // END ADDITIONAL INDEX

        // START ORDER INDEX RELATION


//        $this->call(OrderDiscountTableSeeder::class);

        $this->call(OrderBonusesTabelSeeder::class);
        
        $this->call(OrderStatusListTableSeeder::class);
        // START ORDER INDEX RELATION

        // START ADDITIONAL TO PRODUCTS

        $this->call(ProductDescriptionTableSeeder::class);

        // END ADDITIONAL TO PRODUCTS

        // START SUB PRODUCT AREA
        $this->call(ProductColorTableSeeder::class);
        $this->call(ProductSizeTableSeeder::class);
        $this->call(SubProductTableSeeder::class);
        $this->call(ProductPhotoTableSeeder::class);
        $this->call(OrderIndexSubProductTableSeeder::class);
        // END SUB PRODUCT AREA

        //START LOG USER AREA
        $this->call(LogFromToStringTableSeeder::class);
        $this->call(LogFromToIntTableSeeder::class);
        $this->call(LogUserActionSeeder::class);
        $this->call(LogUserTableSeeder::class);
        $this->call(LogOrderActionSeeder::class);
        $this->call(LogOrderTableSeeder::class);
        //END LOG USER AREA

        // products popularity
        $this->call(ProductPopularityTableSeeder::class);


        // Subscription Area
        $this->call(SubscribationsTypeSeeder::class);
        $this->call(SubscribationsSeeder::class);
        $this->call(UsersSubscribationsSeeder::class);
        //End Subscription Area

        $this->call(PaymentReceiveTableSeeder::class);

        //START SIZE CHART AREA
        $this->call(MeasurementsNamesTableSeeder::class);
        $this->call(SizeChartTableSeeder::class);
        $this->call(MeasurementsTableSeeder::class);
        //END SIZE CHART AREA

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
