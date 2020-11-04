from django.urls import path

from . import views



urlpatterns = [
    path("courses-almaty/", views.CoursesView.as_view(), name='courses-almaty', ),




    ]

"""
 path("", views.ContentView.as_view(), name="add_content"),
 """


