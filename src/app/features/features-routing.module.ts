import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import {FeaturesComponent} from "./features.component";
import {ProfileNameComponent} from "./profileName/profileName.component";
import {ProfileEmailComponent} from "./profileEmail/profileEmail.component";
import {ProfilePhoneComponent} from "./profilePhone/profilePhone.component";
import {HomeComponent} from "./home/home.component";
import {ProfileBankComponent} from "./profileBank/profileBank.component";
import {SendMoneyComponent} from "./sendMoney/sendMoney.component";
import {RequestMoneyComponent} from "./requestMoney/requestMoney.component";
import {SearchTransactionComponent} from "./searchTransaction/searchTransaction.component";
import {StatementComponent} from "./statement/statement.component";

// TIJN application features routing

 const routes: Routes = [
     { path:'', component: FeaturesComponent,

     children: [
       {path:'', component: HomeComponent},
       {path:'profileName', component: ProfileNameComponent},
       {path:'profileEmail', component: ProfileEmailComponent},
       {path:'profilePhone', component: ProfilePhoneComponent},
       {path:'profileBank', component: ProfileBankComponent},
       {path:'sendMoney', component: SendMoneyComponent},
       {path:'requestMoney', component: RequestMoneyComponent},
       {path:'statement', component: StatementComponent},
       {path:'searchTransaction', component: SearchTransactionComponent}
     ]
     }
 ];

@NgModule({
  imports: [RouterModule.forChild(routes)],

  exports: [RouterModule]
})
export class FeaturesRoutingModule { }
