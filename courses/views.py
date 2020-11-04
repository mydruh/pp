from django.shortcuts import render , redirect
from django.views.generic.base import View
from .models import Courses
from .forms import ReviewForm
from django.http import HttpResponse
from django.views.decorators.csrf import csrf_exempt
from django.views.decorators.csrf import ensure_csrf_cookie

class CoursesView(View):
    def get(self,request):
        courses = Courses.objects.all()
        return render(request, "courses.html", {"courses_list": courses})
    def post(self,request):

        form = ReviewForm(request.POST)

        form.save(commit=False)

        return redirect("/")






def fransh(request):



    return render(request, 'fransh.html')





        

