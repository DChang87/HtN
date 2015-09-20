package co.smartmeds.smartmeds;

import android.app.Activity;
import android.app.AlarmManager;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.support.v4.content.WakefulBroadcastReceiver;
import android.support.v7.app.NotificationCompat;
import android.util.Log;
import android.widget.Toast;

import java.util.Calendar;
import java.util.Random;

public class AlarmReceiver extends WakefulBroadcastReceiver {

    @Override
    public void onReceive(Context context, Intent intent) {
        Intent nIntent = new Intent(context, MainActivity.class);
// use System.currentTimeMillis() to have a unique ID for the pending intent
        PendingIntent pIntent = PendingIntent.getActivity(context, (int) System.currentTimeMillis(), nIntent, 0);

// build notification
// the addAction re-use the same intent to keep the example short
        Calendar calendar = Calendar.getInstance();
        Notification n  = new Notification.Builder(context)
                .setContentTitle("Time to take your "+intent.getStringExtra("medicine")+" "+intent.getStringExtra("name")+ " @ "+calendar.get(Calendar.HOUR_OF_DAY)+":"+calendar.get(Calendar.MINUTE)+":"+calendar.get(Calendar.SECOND)+"!")
                .setContentText(intent.getStringExtra("dose") + " of " + intent.getStringExtra("medicine") + " from " + intent.getStringExtra("company") + " at "+calendar.get(Calendar.HOUR_OF_DAY)+":"+calendar.get(Calendar.MINUTE)+":"+calendar.get(Calendar.SECOND))
                .setSmallIcon(R.drawable.logo_red)
                .setContentIntent(pIntent)
                .setAutoCancel(true).build();


        NotificationManager notificationManager =
                (NotificationManager) context.getSystemService(context.NOTIFICATION_SERVICE);

        notificationManager.notify((new Random()).nextInt(1000), n);
    }

}