from django.urls import path, include
from . import views
from .views import Flash


urlpatterns = [



    path("flash/", views.FlashView.as_view(),name = 'flash',),





]