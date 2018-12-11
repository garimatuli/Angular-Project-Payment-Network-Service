import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import {LoginComponent} from "./login/login.component";
import {RegisterComponent} from "./register/register.component";

import { LoginGuard } from './guard/loginGuard';

// Global Routing here, our application tries to go in Feature Module which is first checked if user is logged in or not
// If Logged in, it will go to feature module
// If not Logged in, it will come to login page

const routes: Routes = [

  { path:'', loadChildren: './features/features.module#FeaturesModule' , canActivate: [LoginGuard] },
  { path:'login', component:LoginComponent },
  { path:'register', component:RegisterComponent }

  ];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
