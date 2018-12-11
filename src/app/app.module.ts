import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from  '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS } from "@angular/common/http";

// Global Routing Module File

import { AppRoutingModule } from './app-routing.module';

// Parent Component - App Component, Child - Login, Register and Alert Component

import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { AlertComponent } from "./alert/alert.component";

// All Global Services

import { UserInfoService } from "./services/user-info.service";
import { AlertService } from "./services/alert.service";
import { LoginGuard } from './guard/loginGuard';
import { ErrorHandlerService } from "./services/errorHandler.service";

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    AlertComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule
  ],
  providers: [
    UserInfoService,
    LoginGuard,

    // Error Handler Service for intercepting HTTP Error Response
    {
      provide: HTTP_INTERCEPTORS,
      useClass: ErrorHandlerService,
      multi: true
    },

    AlertService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
