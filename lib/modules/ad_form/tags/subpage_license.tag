<div class="blockLicense">
    <if:[param23]=='Y'>
        <div class="license-item">
            <label>
                <input type="checkbox" name="personal_accepted" {$personal_checked} required>
                <span class="text-license">[param24]</span>
            </label>
        </div>
    </if>
    <if:[param25]=='Y'>
        <div class="license-item">
            <label>
                <input type="checkbox" name="additional_accepted" {$additional_checked} required>
                <span class="text-license">[param26]</span>
            </label>
        </div>
    </if>
</div>
