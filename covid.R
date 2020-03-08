url<- "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_time_series/time_series_19-covid-Confirmed.csv"
library(RCurl)
x <- getURL(url)
## Or 
## x <- getURL(URL, ssl.verifypeer = FALSE)
out <- read.csv(textConnection(x))

library(tidyverse)

series<-out %>% select(-Province.State,-Lat,-Long) %>% reshape2::melt(value.name="count", variable.name="date") %>% group_by(Country.Region,date) %>% summarise(count=sum(count))
series$date = gsub("X","",series$date)
series$date = lubridate::mdy(series$date)


top_count = series %>% ungroup() %>% group_by(Country.Region) %>% summarise(max=max(count,na.rm=TRUE))


to_include = filter(top_count,max>40)


to_include = filter(to_include, !(Country.Region %in% c("Others", "Iceland", "Iran", "Iraq", "Thailand")))
#library(patchwork)

# covid<-read_csv("~/Desktop/covid.csv", col_names=c("date","n"))
# covid$date=parse_date(covid$date,"%d/%m/%y")
# ggplot(covid,aes(x=date,y=n))+geom_point() +
#   geom_smooth(method="glm",fullrange=TRUE,
#               method.args=list(family=gaussian(link="log")))+coord_cartesian(xlim=c(parse_date("2020-03-01"),parse_date("2020-03-10")))
# 
# """

# 
# //a<-ggplot(covid,aes(x=date,y=n))+coord_cartesian(xlim=c(parse_date("2020-03-02"),parse_date("2020-03-10")),ylim=c(0,250)) +geom_point(data=preds,color="blue", alpha=0.9) +geom_line(data=preds,color="blue", alpha=0.1)+labs(x="Date",y="UK infections with exponential fit")+geom_point(color="red")
# //b<-ggplot(covid,aes(x=date,y=n)) +geom_point(data=preds,color="blue", alpha=0.5) +geom_line(data=preds,color="blue", alpha=0.9)+labs(x="Date",y="UK infections with exponential fit")+geom_point(color="red")
# //a+b
# //ggsave("~/Desktop/covid.pdf",width=9,height=5)


library(jsonlite)

process_country <- function(country){
covid = filter(series, Country.Region == country) %>% arrange(date) %>% filter(date>parse_date("2020-02-29")) %>%mutate(n=count)%>% select(-Country.Region,-count)
covid = filter(covid, !is.na(n))
print(covid)
dates= covid$date
exponential.model <- lm(log(covid$n)~ dates)
input_days = parse_date("2020-03-01") + 0:60
predictions <- exp(predict(exponential.model,list(dates=input_days)))
predictions = round(predictions)
preds = tibble(date= input_days, n= predictions)

#preds = filter(preds, n<2000000)
exportJSON <- toJSON(preds)

write(exportJSON, paste0("~/Desktop/covid/",country,".predictions.json"))



exportJSON <- toJSON(covid)

write(exportJSON, paste0("~/Desktop/covid/",country,".raw.json"))
}


for(country in to_include$Country.Region){
  process_country(country)
}

