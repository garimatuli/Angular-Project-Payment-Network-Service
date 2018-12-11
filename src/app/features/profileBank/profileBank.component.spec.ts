import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ProfileBankComponent } from './profileBank.component';

describe('ProfileBankComponent', () => {
  let component: ProfileBankComponent;
  let fixture: ComponentFixture<ProfileBankComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ProfileBankComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ProfileBankComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
