package co.smartmeds.smartmeds;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import java.util.ArrayList;

/**
 * Created by Kevin on 9/20/2015.
 */
public class ItemAdapter extends ArrayAdapter<Item> {
    public ItemAdapter(Context context, ArrayList<Item> users) {
        super(context, 0, users);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        // Get the data item for this position
        Item user = getItem(position);
        // Check if an existing view is being reused, otherwise inflate the view
            convertView = LayoutInflater.from(getContext()).inflate(R.layout.list_item, parent, false);
        // Lookup view for data population
        TextView tvTitle = (TextView) convertView.findViewById(R.id.tvtitle);
        TextView tvMeta = (TextView) convertView.findViewById(R.id.tvmetadata);
        TextView tvDate = (TextView) convertView.findViewById(R.id.tvdate);
        // Populate the data into the template view using the data object
        tvTitle.setText(user.title);
        tvMeta.setText(user.metadata);
        tvDate.setText(user.date);
        // Return the completed view to render on screen
        return convertView;
    }
}
