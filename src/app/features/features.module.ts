import { NgModule, Optional, SkipSelf } from '@angular/core';

import {FeaturesComponent} from "./features.component";
import {NavigationComponent} from "../navigation/navigation.component";
import { ProfileNameComponent } from './profileName/profileName.component';

import {FeaturesRoutingModule} from "./features-routing.module";
import { FormsModule } from "@angular/forms";
import { CommonModule} from "@angular/common";
import { ProfileEmailComponent } from './profileEmail/profileEmail.component';

import { DialogBoxComponent } from "../dialogBox/dialogBox.component";

import { ModalModule } from 'ngx-bootstrap/modal';
import { ProfileService } from "./services/profile.service";

import { throwIfAlreadyLoaded} from "./module-import-guard";
import { ProfilePhoneComponent } from './profilePhone/profilePhone.component';
import {HomeComponent} from "./home/home.component";
import { ProfileBankComponent } from './profileBank/profileBank.component';
import { SendMoneyComponent } from './sendMoney/sendMoney.component';
import { RequestMoneyComponent } from './requestMoney/requestMoney.component';
import {sendMoneyService} from "./services/sendMoney.service";
import { StatementComponent } from './statement/statement.component';
import { SearchTransactionComponent } from './searchTransaction/searchTransaction.component';
import {requestMoneyService} from "./services/requestMoney.service";

import {statementService} from "./services/statement.service";

import { BsDatepickerModule } from 'ngx-bootstrap/datepicker';
import { DatePipe} from "@angular/common";
import {searchTransactionService} from "./services/searchTransaction.service";


@NgModule({
  imports: [
    FeaturesRoutingModule,
    FormsModule,
    CommonModule,
    ModalModule.forRoot(),
    BsDatepickerModule.forRoot()
  ],
  declarations: [
    FeaturesComponent,
    NavigationComponent,
    HomeComponent,
    ProfileNameComponent,
    ProfileEmailComponent,
    DialogBoxComponent,
    ProfilePhoneComponent,
    ProfileBankComponent,
    SendMoneyComponent,
    RequestMoneyComponent,
    StatementComponent,
    SearchTransactionComponent
  ],
  providers: [
    ProfileService,
    sendMoneyService,
    requestMoneyService,
    statementService,
    searchTransactionService,
    DatePipe
  ]
})

export class FeaturesModule {

  constructor( @Optional() @SkipSelf() parentModule: FeaturesModule) {
    throwIfAlreadyLoaded(parentModule, 'CoreModule');
  }

}
