<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\FanCostEntry;
use App\Models\FanCostEntryItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FanCostingController extends Controller
{
    /**
     * The 37 fixed fan cost item templates.
     */
    private function itemTemplates(): array
    {
        return [
            ['sort_order' =>  1, 'name_bn' => 'বডি কভার',                          'name_en' => 'Body Cover',                     'category' => 'raw_material'],
            ['sort_order' =>  2, 'name_bn' => 'আর্মিচার + রোটর',                   'name_en' => 'Armature + Rotor',               'category' => 'raw_material'],
            ['sort_order' =>  3, 'name_bn' => 'সুপার তার',                          'name_en' => 'Super Enamel',                   'category' => 'raw_material'],
            ['sort_order' =>  4, 'name_bn' => 'ইংগট',                               'name_en' => 'Ingot',                          'category' => 'raw_material'],
            ['sort_order' =>  5, 'name_bn' => 'স্কেল',                              'name_en' => 'Scale',                          'category' => 'raw_material'],
            ['sort_order' =>  6, 'name_bn' => 'ডাউনপাইপ',                           'name_en' => 'Downpipe',                       'category' => 'raw_material'],
            ['sort_order' =>  7, 'name_bn' => 'ব্লেড + স্যাং',                      'name_en' => 'Blade Sheet',                    'category' => 'raw_material'],
            ['sort_order' =>  8, 'name_bn' => 'ক্যাপাসিটর',                         'name_en' => 'Capacitor',                      'category' => 'raw_material'],
            ['sort_order' =>  9, 'name_bn' => 'বেয়ারিং',                            'name_en' => 'Bearing',                        'category' => 'raw_material'],
            ['sort_order' => 10, 'name_bn' => 'নাট + বোল্ট',                        'name_en' => 'Nut + Bolt',                     'category' => 'raw_material'],
            ['sort_order' => 11, 'name_bn' => 'ক্যানোপি',                           'name_en' => 'Canopy',                         'category' => 'packing'],
            ['sort_order' => 12, 'name_bn' => 'সুকাপ',                              'name_en' => 'Sucup',                          'category' => 'packing'],
            ['sort_order' => 13, 'name_bn' => 'পরিবহন',                             'name_en' => 'Transportation',                 'category' => 'overhead'],
            ['sort_order' => 14, 'name_bn' => 'ফাইবার',                             'name_en' => 'Fiber',                          'category' => 'raw_material'],
            ['sort_order' => 15, 'name_bn' => 'আন্ডারকোট',                          'name_en' => 'Undercoat',                      'category' => 'raw_material'],
            ['sort_order' => 16, 'name_bn' => 'মিনার',                              'name_en' => 'Minar',                          'category' => 'raw_material'],
            ['sort_order' => 17, 'name_bn' => 'সোলডিং + গ্যাস',                     'name_en' => 'Soldering + Gas',                'category' => 'overhead'],
            ['sort_order' => 18, 'name_bn' => 'সুতা + কাগজ + সুতলি',               'name_en' => 'Thread + Paper + Winding',       'category' => 'raw_material'],
            ['sort_order' => 19, 'name_bn' => 'লুবতর',                              'name_en' => 'Lubtor',                         'category' => 'overhead'],
            ['sort_order' => 20, 'name_bn' => 'ক্যাপাসিটর (২)',                     'name_en' => 'Capacitor (2)',                  'category' => 'raw_material'],
            ['sort_order' => 21, 'name_bn' => 'গ্যাচলিট',                           'name_en' => 'Gachlit',                        'category' => 'raw_material'],
            ['sort_order' => 22, 'name_bn' => 'ঘরভাড়া',                            'name_en' => 'Rent',                           'category' => 'overhead'],
            ['sort_order' => 23, 'name_bn' => 'মজুরি',                              'name_en' => 'Wages',                          'category' => 'labor'],
            ['sort_order' => 24, 'name_bn' => 'যন্ত্রপাতি + অবচয়',                 'name_en' => 'Equipment + Depreciation',       'category' => 'overhead'],
            ['sort_order' => 25, 'name_bn' => 'কাইমস',                              'name_en' => 'Kaims',                          'category' => 'raw_material'],
            ['sort_order' => 26, 'name_bn' => 'কার্টন',                             'name_en' => 'Carton',                         'category' => 'packing'],
            ['sort_order' => 27, 'name_bn' => 'বিদ্যুৎ + ডিজেল',                   'name_en' => 'Electricity + Diesel',           'category' => 'overhead'],
            ['sort_order' => 28, 'name_bn' => 'আপ্যায়ন + নাস্তা',                  'name_en' => 'Entertainment + Snacks',         'category' => 'overhead'],
            ['sort_order' => 29, 'name_bn' => 'স্ক্রু',                             'name_en' => 'Screw',                          'category' => 'raw_material'],
            ['sort_order' => 30, 'name_bn' => 'রং পাউডার রোড ও ডোকো',              'name_en' => 'Color Powder Code',              'category' => 'raw_material'],
            ['sort_order' => 31, 'name_bn' => 'রিপ্লেস',                            'name_en' => 'Replacement',                    'category' => 'other'],
            ['sort_order' => 32, 'name_bn' => 'মোবিল + কসটেপ + নিশাদল + কালি',    'name_en' => 'Mobil + Costep + Ink',           'category' => 'overhead'],
            ['sort_order' => 33, 'name_bn' => 'পলিথিন + টিউব',                     'name_en' => 'Polythene + Tube',               'category' => 'packing'],
            ['sort_order' => 34, 'name_bn' => 'রিপিট + এলু',                        'name_en' => 'Repeat + Alu',                   'category' => 'raw_material'],
            ['sort_order' => 35, 'name_bn' => 'বার্নিশ + সলভিন',                   'name_en' => 'Varnish + Solvin',               'category' => 'raw_material'],
            ['sort_order' => 36, 'name_bn' => 'গ্রীজ + মোজা + পলিশ',               'name_en' => 'Grease + Polish',                'category' => 'overhead'],
            ['sort_order' => 37, 'name_bn' => 'ষ্টেশনারী + বিবিধ',                 'name_en' => 'Stationery + Miscellaneous',     'category' => 'other'],
        ];
    }

    public function index()
    {
        $entries = FanCostEntry::where('company_id', auth()->user()->company_id)
            ->orderByDesc('entry_date')
            ->orderByDesc('id')
            ->paginate(20);

        return Inertia::render('Production/FanCosting/Index', [
            'entries' => $entries,
        ]);
    }

    public function create()
    {
        return Inertia::render('Production/FanCosting/Create', [
            'templates' => $this->itemTemplates(),
            'nextNumber' => $this->generateEntryNumber(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'entry_date'    => 'required|date',
            'fan_model'     => 'nullable|string|max:150',
            'title'         => 'nullable|string|max:200',
            'quantity'      => 'required|numeric|min:0.01',
            'selling_price' => 'required|numeric|min:0',
            'status'        => 'required|in:draft,finalized',
            'items'         => 'required|array|min:1',
            'items.*.sort_order'   => 'required|integer',
            'items.*.name_bn'      => 'required|string|max:200',
            'items.*.name_en'      => 'required|string|max:200',
            'items.*.category'     => 'required|in:raw_material,labor,overhead,packing,other',
            'items.*.qty'          => 'required|numeric|min:0',
            'items.*.unit_price'   => 'required|numeric|min:0',
            'items.*.appreciation' => 'required|numeric|min:0|max:999',
            'items.*.source'       => 'required|in:purchase,in_house',
        ]);

        $itemsWithAmounts = $this->computeItemAmounts($request->items);
        $totals = $this->calculateTotals($itemsWithAmounts, $request->quantity, $request->selling_price);

        $entry = FanCostEntry::create(array_merge([
            'company_id'    => auth()->user()->company_id,
            'entry_number'  => $this->generateEntryNumber(),
            'entry_date'    => $request->entry_date,
            'fan_model'     => $request->fan_model,
            'title'         => $request->title,
            'quantity'      => $request->quantity,
            'selling_price' => $request->selling_price,
            'status'        => $request->status,
            'created_by'    => auth()->id(),
        ], $totals));

        foreach ($itemsWithAmounts as $item) {
            $entry->items()->create([
                'sort_order'   => $item['sort_order'],
                'name_bn'      => $item['name_bn'],
                'name_en'      => $item['name_en'],
                'category'     => $item['category'],
                'qty'          => $item['qty'],
                'unit_price'   => $item['unit_price'],
                'appreciation' => $item['appreciation'],
                'source'       => $item['source'],
                'amount'       => $item['amount'],
            ]);
        }

        return redirect()->route('production.fan-costing.show', $entry->id)
            ->with('success', 'Cost entry saved successfully.');
    }

    public function show(string $id)
    {
        $entry = FanCostEntry::where('company_id', auth()->user()->company_id)
            ->with('items')
            ->findOrFail($id);

        return Inertia::render('Production/FanCosting/Show', [
            'entry' => $entry,
        ]);
    }

    public function edit(string $id)
    {
        $entry = FanCostEntry::where('company_id', auth()->user()->company_id)
            ->with('items')
            ->findOrFail($id);

        return Inertia::render('Production/FanCosting/Edit', [
            'entry' => $entry,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $entry = FanCostEntry::where('company_id', auth()->user()->company_id)->findOrFail($id);

        $request->validate([
            'entry_date'    => 'required|date',
            'fan_model'     => 'nullable|string|max:150',
            'title'         => 'nullable|string|max:200',
            'quantity'      => 'required|numeric|min:0.01',
            'selling_price' => 'required|numeric|min:0',
            'status'        => 'required|in:draft,finalized',
            'items'         => 'required|array|min:1',
            'items.*.sort_order'   => 'required|integer',
            'items.*.name_bn'      => 'required|string|max:200',
            'items.*.name_en'      => 'required|string|max:200',
            'items.*.category'     => 'required|in:raw_material,labor,overhead,packing,other',
            'items.*.qty'          => 'required|numeric|min:0',
            'items.*.unit_price'   => 'required|numeric|min:0',
            'items.*.appreciation' => 'required|numeric|min:0|max:999',
            'items.*.source'       => 'required|in:purchase,in_house',
        ]);

        $itemsWithAmounts = $this->computeItemAmounts($request->items);
        $totals = $this->calculateTotals($itemsWithAmounts, $request->quantity, $request->selling_price);

        $entry->update(array_merge([
            'entry_date'    => $request->entry_date,
            'fan_model'     => $request->fan_model,
            'title'         => $request->title,
            'quantity'      => $request->quantity,
            'selling_price' => $request->selling_price,
            'status'        => $request->status,
        ], $totals));

        $entry->items()->delete();
        foreach ($itemsWithAmounts as $item) {
            $entry->items()->create([
                'sort_order'   => $item['sort_order'],
                'name_bn'      => $item['name_bn'],
                'name_en'      => $item['name_en'],
                'category'     => $item['category'],
                'qty'          => $item['qty'],
                'unit_price'   => $item['unit_price'],
                'appreciation' => $item['appreciation'],
                'source'       => $item['source'],
                'amount'       => $item['amount'],
            ]);
        }

        return redirect()->route('production.fan-costing.show', $entry->id)
            ->with('success', 'Cost entry updated successfully.');
    }

    public function destroy(string $id)
    {
        $entry = FanCostEntry::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $entry->delete();

        return redirect()->route('production.fan-costing.index')
            ->with('success', 'Cost entry deleted.');
    }

    /**
     * amount = qty × unit_price × (1 + appreciation/100)
     */
    private function computeItemAmounts(array $items): array
    {
        return array_map(function ($item) {
            $qty    = (float) ($item['qty'] ?? 0);
            $price  = (float) ($item['unit_price'] ?? 0);
            $appPct = (float) ($item['appreciation'] ?? 0);
            $amount = $qty * $price * (1 + $appPct / 100);
            return array_merge($item, ['amount' => round($amount, 2)]);
        }, $items);
    }

    private function calculateTotals(array $items, float $qty, float $sellingPrice): array
    {
        $materialCost  = 0;
        $laborCost     = 0;
        $overheadCost  = 0;
        $packingCost   = 0;
        $otherCost     = 0;

        foreach ($items as $item) {
            $amount = (float) ($item['amount'] ?? 0);
            match ($item['category']) {
                'raw_material' => $materialCost  += $amount,
                'labor'        => $laborCost     += $amount,
                'overhead'     => $overheadCost  += $amount,
                'packing'      => $packingCost   += $amount,
                'other'        => $otherCost     += $amount,
                default        => null,
            };
        }

        $totalCost    = $materialCost + $laborCost + $overheadCost + $packingCost + $otherCost;
        $unitCost     = $qty > 0 ? $totalCost / $qty : 0;
        $grossProfit  = ($sellingPrice - $unitCost) * $qty;
        $totalRevenue = $sellingPrice * $qty;
        $marginPct    = $totalRevenue > 0 ? ($grossProfit / $totalRevenue) * 100 : 0;

        return [
            'total_material_cost' => round($materialCost, 2),
            'total_labor_cost'    => round($laborCost, 2),
            'total_overhead_cost' => round($overheadCost, 2),
            'total_packing_cost'  => round($packingCost, 2),
            'total_other_cost'    => round($otherCost, 2),
            'total_cost'          => round($totalCost, 2),
            'unit_cost'           => round($unitCost, 4),
            'gross_profit'        => round($grossProfit, 2),
            'gross_margin_pct'    => round($marginPct, 2),
        ];
    }

    private function generateEntryNumber(): string
    {
        $year  = date('Y');
        $month = date('m');
        $last  = FanCostEntry::where('entry_number', 'like', "FC-{$year}{$month}-%")
            ->orderByDesc('id')
            ->value('entry_number');

        $seq = $last ? ((int) substr($last, -4)) + 1 : 1;

        return "FC-{$year}{$month}-" . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
