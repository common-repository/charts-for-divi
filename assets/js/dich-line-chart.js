/**
 * Dich Line Chart JS
 */

(function ($) {
  $(document).ready(function () {
    $(".dich-charts-line").each(function () {
      const { categories, series, datas } = $(this).data();
      const categoriesArr = categories.split(",");
      const width = [];
      const colors = [];
      const yaxis = [];
      const seriesArr = Object.values(series).map((item) => {
        width.push(item.line_width);
        colors.push(item.line_color);

        if ("on" === datas.show_vertical_labels) {
          yaxis.push({
            axisBorder: {
              show: "on" === item.show_vertical_border,
              color: item.vertical_border_color,
            },
            labels: {
              show: "on" === item.show_label,
              style: {
                colors: item.label_color,
              },
            },
          });
        }

        return {
          name: item.name,
          data: item?.data?.split(",") || [],
        };
      });
      const toolbar_settings = (datas.use_options || "").split("|");
      const height =
        "" !== datas?.min_height && datas.min_height > datas?.height
          ? datas.min_height
          : datas?.height || 350;
      const options = {
        chart: {
          type: "line",
          // stacked: false,
          height,
          toolbar: {
            // show: false,
            tools: {
              download: "on" === toolbar_settings[0],
              zoom: "on" === toolbar_settings[1],
              zoomin: "on" === toolbar_settings[2],
              zoomout: "on" === toolbar_settings[3],
              pan: "on" === toolbar_settings[4],
              reset: "on" === toolbar_settings[5],
            },
          },
        },
        series: seriesArr, // [ { name: 'Series 1', data: [4,5,6,7] } ]
        colors: "none" === datas?.color_palette ? colors : [],
        xaxis: {
          categories: categoriesArr || [], // E.x: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999],
        },
        dataLabels: {
          enabled: "on" === datas?.show_data_labels,
        },
        ...("on" === datas.show_vertical_labels && { yaxis }),
        stroke: {
          curve: datas?.chart_line_type || "straight",
          width,
        },
        markers: {
          size: "on" === datas?.show_markers ? +datas?.marker_size : 0,
        },
        legend: {
          show: true,
          position: datas?.legend_position || "top",
        },
        theme:
          "on" === datas?.enable_theme
            ? {
                mode: datas?.theme_mode,
                palette: datas?.color_palette,
                monochrome: {
                  enabled:
                    "on" === datas?.enable_theme &&
                    "on" === datas?.enable_monochrome,
                  color: datas?.monochrome_color,
                  shadeTo: datas?.shade_to,
                  shadeIntensity: +datas?.shade_intensity,
                },
              }
            : {},
      };

      const chart = new ApexCharts(this, options);
      chart.render();
    });
  });
})(jQuery);
